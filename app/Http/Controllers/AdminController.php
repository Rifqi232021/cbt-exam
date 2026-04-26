<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Student;
use App\Models\Result;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $questionsCount = Question::count();
        $studentsCount = Student::count();
        $resultsCount = Result::count();

        return view('admin.dashboard', compact('questionsCount', 'studentsCount', 'resultsCount'));
    }

    public function questions()
    {
        $questions = Question::all();
        return view('admin.questions', compact('questions'));
    }

    public function createQuestion(Request $request)
    {
        $data = $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|string',
            'correct_answer' => 'required|string',
            'subject' => 'nullable|string',
            'difficulty' => 'nullable|string',
        ]);

        $options = json_decode($data['options'], true);
        if (!is_array($options)) {
            $options = array_map('trim', explode(',', $data['options']));
        }

        Question::create([
            'question_text' => $data['question_text'],
            'options' => $options,
            'correct_answer' => $data['correct_answer'],
            'subject' => $data['subject'] ?? null,
            'difficulty' => $data['difficulty'] ?? null,
        ]);

        return redirect()->route('admin.questions')->with('success', 'Question created successfully.');
    }

    public function students()
    {
        $students = Student::all();
        return view('admin.students', compact('students'));
    }

    public function createStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'school' => 'required|string',
            'exam_type' => 'required|in:uts,uas',
            'token' => 'required|string',
        ]);

        Student::create($request->only(['name', 'school', 'exam_type', 'token']));
        return redirect()->route('admin.students')->with('success', 'Student created successfully.');
    }

    public function results()
    {
        $results = Result::with('student')->get();
        return view('admin.results', compact('results'));
    }
}