<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'question_id',
        'answer',
        'is_correct',
    ];

    // Relationship with student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relationship with question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}