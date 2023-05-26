<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'role'    => $this->name,
            'users'   => $this->users()->pluck('avatar')->map(fn ($avatar) => asset($avatar ?? 'assets/img/user.webp')),
            'details' => [
                'id'          => $this->id,
                'name'        => $this->name,
                'permissions' => $this->perms($this->permissions)
            ],
            'editable'  => $request->user()->can('update', $this->resource),
            'deletable' => $request->user()->can('delete', $this->resource),
        ];
    }

    /**
     * Prepare the permissions
     */
    public function perms($permissions)
    {
        $perms = [];
        $names = [
            'role' => 'Roles',
            'user' => 'Users'
        ];
        $permissions->map(function ($permission) use (&$perms, $names) {
            foreach ($names as $name => $value) {
                if (str_contains($permission->name, $name)) {
                    $perms[$value]['name'] = $value;
                    $perms[$value][$permission->name] = true;
                    break;
                }
            }
        });
        return array_values($perms);
    }
}
