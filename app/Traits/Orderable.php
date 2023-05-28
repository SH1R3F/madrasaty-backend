<?php

namespace App\Traits;

use App\Models\Note;
use App\Models\User;
use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Database\Eloquent\Builder;

trait Orderable
{
    /**
     * Order scope
     */
    public function scopeOrder(Builder $query, array $sort)
    {

        if (!count($sort)) {
            return $query->orderBy('id', 'DESC');
        }

        foreach ($sort as $arrange) {

            $key   = $arrange['key'];
            $order = $arrange['order'];

            switch ($key) {
                case 'user':
                    if ($this instanceof User) {
                        $query->orderBy('name', $order);
                    } else if ($this instanceof Note) {
                        $query->orderBy(function ($query) {
                            return $query->from('users')
                                ->whereRaw("`users`.id = `notes`.user_id")
                                ->select('name');
                        }, $order);
                    }
                    break;
                case 'role':
                    if ($this instanceof User) {
                        $query->orderBy(function ($query) {
                            return $query->from('model_has_roles')
                                ->whereRaw("`model_has_roles`.model_id = `users`.id")
                                ->select('role_id');
                        }, $order);
                    }
                    break;
                case 'classroom':
                    if ($this instanceof Student) {
                        $query->orderBy(function ($query) {
                            return $query->from('classrooms')
                                ->whereRaw("`classrooms`.id = `students`.classroom_id")
                                ->select('name');
                        }, $order);
                    }
                    if ($this instanceof Note) {
                        $query->orderBy(function ($query) {
                            return $query->from('classrooms')
                                ->whereRaw("`classrooms`.id = `notes`.classroom_id")
                                ->select('name');
                        }, $order);
                    }
                    break;

                case 'student':
                    if ($this instanceof Note) {
                        $query->orderBy(function ($query) {
                            return $query->from('students')
                                ->whereRaw("`students`.id = `notes`.student_id")
                                ->select('name');
                        }, $order);
                    }
                    break;

                case 'students':
                    if ($this instanceof Classroom) {
                        $query->orderBy('students_count', $order);
                    }
                    break;

                default:
                    if (in_array($key, \Illuminate\Support\Facades\Schema::getColumnListing($this->getTable()))) {
                        $query->orderBy($key, $order);
                    }
            }
        }
    }
}
