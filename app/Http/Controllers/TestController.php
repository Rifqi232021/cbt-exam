<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Student;
use App\Models\Answer;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class TestController extends Controller
{
    public function start(Request $request)
    {
        $request->validate([
            'jenis_ujian' => 'required|in:uts,uas',
            'nama' => 'required|string|max:255',
            'sekolah' => 'required|in:smk1,sma4,sma8',
            'token' => 'required|string',
        ]);

        if ($request->token !== '232021') {
            return redirect()->back()->withErrors(['token' => 'Token ujian salah. Gunakan 232021.']);
        }

        $student = Student::updateOrCreate(
            [
                'name' => $request->nama,
                'school' => $request->sekolah,
                'exam_type' => $request->jenis_ujian,
                'token' => $request->token,
            ],
            [
                'name' => $request->nama,
                'school' => $request->sekolah,
                'exam_type' => $request->jenis_ujian,
                'token' => $request->token,
            ]
        );

        Session::put('student_data', [
            'id' => $student->id,
            'name' => $student->name,
            'school' => $student->school,
            'exam_type' => $student->exam_type,
        ]);

        $questions = Question::inRandomOrder()->take(10)->get();

        Session::put('test_student_id', $student->id);
        Session::put('test_questions', $questions->pluck('id'));
        Session::put('test_start_time', now());

        return view('test.start', compact('questions', 'student'));
    }

    public function submit(Request $request)
    {
        $studentId = Session::get('test_student_id');
        $questionIds = Session::get('test_questions');
        $startTime = Session::get('test_start_time');

        $timeTaken = now()->diffInSeconds($startTime);

        $score = 0;
        $totalQuestions = count($questionIds);

        foreach ($questionIds as $questionId) {
            $answer = $request->input('answer_' . $questionId);
            $question = Question::find($questionId);
            $isCorrect = $answer === $question->correct_answer;

            if ($isCorrect) {
                $score++;
            }

            Answer::create([
                'student_id' => $studentId,
                'question_id' => $questionId,
                'answer' => $answer,
                'is_correct' => $isCorrect,
            ]);
        }

        Result::create([
            'student_id' => $studentId,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'time_taken' => $timeTaken,
            'completed_at' => now(),
        ]);

        Session::forget(['test_student_id', 'test_questions', 'test_start_time']);

        return view('test.result', compact('score', 'totalQuestions', 'timeTaken'));
    }

    public function startApi(Request $request)
    {
        $data = $request->validate([
            'jenis_ujian' => 'required|in:uts,uas',
            'nama' => 'required|string|max:255',
            'sekolah' => 'required|in:smk1,sma4,sma8',
            'token' => 'required|string',
        ]);

        if ($data['token'] !== '232021') {
            return response()->json(['success' => false, 'message' => 'Token ujian salah. Gunakan 232021.'], 422);
        }

        $student = Student::create([
            'name' => $data['nama'],
            'school' => $data['sekolah'],
            'exam_type' => $data['jenis_ujian'],
            'token' => $data['token'],
        ]);

        $sessionToken = hash('sha256', $student->id . microtime());
        $questions = Question::inRandomOrder()->take(10)->get();

        Cache::put("exam_session_{$sessionToken}", [
            'student_db_id' => $student->id,
            'name' => $student->name,
            'school' => $student->school,
            'exam_type' => $student->exam_type,
            'question_ids' => $questions->pluck('id')->toArray(),
            'start_time' => now()->timestamp,
        ], now()->addHours(4));

        return response()->json([
            'success' => true,
            'session_token' => $sessionToken,
            'message' => 'Sesi ujian dimulai.',
        ]);
    }

    public function questionsApi(Request $request)
    {
        $sessionToken = $request->header('X-Session-Token');
        
        if (!$sessionToken) {
            return response()->json(['success' => false, 'message' => 'Sesi ujian belum dimulai.'], 422);
        }

        $examData = Cache::get("exam_session_{$sessionToken}");

        if (!$examData) {
            return response()->json(['success' => false, 'message' => 'Sesi ujian belum dimulai.'], 422);
        }

        $questionIds = $examData['question_ids'];
        $startTime = $examData['start_time'];
        $studentDbId = $examData['student_db_id'];

        $answers = Answer::where('student_id', $studentDbId)
            ->whereIn('question_id', $questionIds)
            ->get()
            ->keyBy('question_id');

        $questions = Question::whereIn('id', $questionIds)
            ->get()
            ->map(function ($question) use ($answers) {
                return [
                    'id' => $question->id,
                    'question_text' => $question->question_text,
                    'options' => $question->options,
                    'selected' => $answers->has($question->id) ? $answers[$question->id]->answer : null,
                ];
            });

        $timeLeft = max(0, 45 * 60 - (now()->timestamp - $startTime));

        return response()->json([
            'success' => true,
            'questions' => $questions,
            'time_left' => $timeLeft,
            'student' => [
                'name' => $examData['name'],
                'school' => $examData['school'],
                'exam_type' => $examData['exam_type'],
            ],
        ]);
    }

    public function saveAnswerApi(Request $request)
    {
        $data = $request->validate([
            'question_id' => 'required|integer|exists:questions,id',
            'answer' => 'nullable|string',
        ]);

        $sessionToken = $request->header('X-Session-Token');
        
        if (!$sessionToken) {
            return response()->json(['success' => false, 'message' => 'Sesi ujian belum dimulai.'], 422);
        }

        $examData = Cache::get("exam_session_{$sessionToken}");

        if (!$examData) {
            return response()->json(['success' => false, 'message' => 'Sesi ujian belum dimulai.'], 422);
        }

        $studentDbId = $examData['student_db_id'];

        $question = Question::find($data['question_id']);
        $isCorrect = $question && $data['answer'] === $question->correct_answer;

        Answer::updateOrCreate(
            ['student_id' => $studentDbId, 'question_id' => $data['question_id']],
            ['answer' => $data['answer'], 'is_correct' => $isCorrect]
        );

        return response()->json(['success' => true, 'message' => 'Jawaban tersimpan.']);
    }

    public function submitApi(Request $request)
    {
        $data = $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|integer|exists:questions,id',
            'answers.*.answer' => 'nullable|string',
        ]);

        $sessionToken = $request->header('X-Session-Token');
        
        if (!$sessionToken) {
            return response()->json(['success' => false, 'message' => 'Sesi ujian belum dimulai.'], 422);
        }

        $examData = Cache::get("exam_session_{$sessionToken}");

        if (!$examData) {
            return response()->json(['success' => false, 'message' => 'Sesi ujian belum dimulai.'], 422);
        }

        $studentDbId = $examData['student_db_id'];
        $questionIds = $examData['question_ids'];
        $startTime = $examData['start_time'];

        $score = 0;
        $totalQuestions = count($questionIds);

        foreach ($data['answers'] as $answerData) {
            if (!in_array($answerData['question_id'], $questionIds)) {
                continue;
            }

            $question = Question::find($answerData['question_id']);
            $isCorrect = $question && $answerData['answer'] === $question->correct_answer;
            if ($isCorrect) {
                $score++;
            }

            Answer::updateOrCreate(
                ['student_id' => $studentDbId, 'question_id' => $answerData['question_id']],
                ['answer' => $answerData['answer'], 'is_correct' => $isCorrect]
            );
        }

        $timeTaken = now()->timestamp - $startTime;

        Result::create([
            'student_id' => $studentDbId,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'time_taken' => $timeTaken,
            'completed_at' => now(),
        ]);

        Cache::forget("exam_session_{$sessionToken}");

        $percentage = ($score / $totalQuestions) * 100;

        return response()->json([
            'success' => true,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'percentage' => round($percentage, 2),
            'message' => 'Ujian selesai.',
        ]);
    }

    public function statusApi(Request $request)
    {
        $sessionToken = $request->header('X-Session-Token');
        if (!$sessionToken) {
            return response()->json(['success' => false, 'started' => false]);
        }

        $examData = Cache::get("exam_session_{$sessionToken}");
        if (!$examData) {
            return response()->json(['success' => false, 'started' => false]);
        }

        return response()->json([
            'success' => true,
            'started' => true,
            'student' => [
                'name' => $examData['name'],
                'school' => $examData['school'],
                'exam_type' => $examData['exam_type'],
            ],
            'time_left' => max(0, 45 * 60 - (now()->timestamp - $examData['start_time'])),
        ]);
    }
}
