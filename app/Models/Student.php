<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Classroom;
use App\Traits\Orderable;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasApiTokens, HasFactory, Notifiable, Searchable, Orderable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'classroom_id',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

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
