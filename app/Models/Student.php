<?php

namespace App\Models;

use App\Models\Classroom;
use App\Traits\Orderable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory, Searchable, Orderable;

    protected $fillable = ['name', 'classroom_id'];


    /**
     * Classroom it belongs to
     */
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
