<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Student;
use App\Models\Result;

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

    public function students()
    {
        $students = Student::all();
        return view('admin.students', compact('students'));
    }

    public function results()
    {
        $results = Result::with('student')->get();
        return view('admin.results', compact('results'));
    }
}