<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'score',
        'total_questions',
        'time_taken',
        'completed_at',
    ];

    // Relationship with student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}