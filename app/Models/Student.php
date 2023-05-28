<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Classroom;
use App\Traits\Orderable;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory, Searchable, Orderable;

    protected $fillable = ['name', 'classroom_id'];

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
        return $this->belongsTo(Classroom::class);
    }

    /**
     * The notes created for this student
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
