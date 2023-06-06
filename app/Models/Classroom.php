<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Student;
use App\Traits\Orderable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classroom extends Model
{
    use HasFactory, Searchable, Orderable;

    protected $fillable = ['name', 'points'];

    public const DEFAULT_POINTS = 100;


    /**
     * Students of this classroom
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'student_id');
    }

    /**
     * The notes created for this classroom
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
