<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Search scope
     */
    public function scopeSearch(Builder $query, ?string $search, array $columns)
    {
        $query->when($search, function ($query) use ($columns, $search) {
            $query->where(function ($query) use ($columns, $search) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', "%{$search}%");
                }
            });
        });
    }
}
