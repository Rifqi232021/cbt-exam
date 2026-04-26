<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'school',
        'exam_type',
        'token',
    ];

    // Relationship with results
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    // Relationship with answers
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}