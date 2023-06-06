<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Note;
use App\Models\Classroom;
use App\Traits\Orderable;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Searchable, Orderable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'status',
        'password',
        'classroom_id',
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
     * Get only the students users
     */
    public static function students()
    {
        return self::with('classroom')->whereHas('roles', fn(Builder $query) => $query->where('name', 'طالب'));
    }

    /**
     * Filter users in admin panel
     */
    public function scopeFilter(Builder $query, Request $request)
    {
        $query
            ->when($request->role, fn ($query, $role) => $query->whereHas('roles', fn ($query) => $query->where('name', $role)))
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->when($request->classroom, fn ($query, $classroom) => $query->where('classroom_id', $classroom));
    }

    /**
     * The notes created by this user
     */
    public function notes()
    {
        return $this->getRoleNames()[0] == 'طالب' ? $this->hasMany(Note::class, 'student_id') : $this->hasMany(Note::class);
    }

    /**
     * The classroom it belongs to
     */
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
