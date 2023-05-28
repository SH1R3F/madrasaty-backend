<?php

namespace App\Models;

use App\Traits\Orderable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory, Searchable, Orderable;

    protected $fillable = ['name', 'points'];

    public const DEFAULT_POINTS = 100;
}
