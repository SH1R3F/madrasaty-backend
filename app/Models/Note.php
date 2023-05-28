<?php

namespace App\Models;

use App\Models\User;
use App\Models\Student;
use App\Models\Classroom;
use App\Traits\Orderable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory, Orderable, Searchable;

    protected $fillable = ['note', 'points', 'user_id', 'student_id', 'classroom_id'];


    // The user created this note
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // The student this note is for
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // The classroom this note is for
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}