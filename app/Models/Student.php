<?php

namespace App\Models;

use App\Models\Note;
use App\Models\User;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class Student extends User
{
    protected $table = 'users';

    /**
     * The "booted" method of the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('student', function (Builder $builder) {
            return $builder->whereHas('roles', fn ($query) => $query->where('name', 'طالب'));
        });
    }

    /**
     * Filter students in admin panel
     */
    public function scopeFilter(Builder $query, Request $request)
    {
        $query->when($request->classroom, fn ($query, $classroom) => $query->where('classroom_id', $classroom));
    }

    /**
     * Classroom it belongs to
     */
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'student_id');
    }

    /**
     * The notes created for this student
     */
    public function notes()
    {
        return $this->hasMany(Note::class, 'student_id');
    }
}
