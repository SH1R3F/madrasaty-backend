<?php

namespace App\Traits;

use App\Models\User;
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
                default:
                    if (in_array($key, \Illuminate\Support\Facades\Schema::getColumnListing($this->getTable()))) {
                        $query->orderBy($key, $order);
                    }
            }
        }
    }
}
