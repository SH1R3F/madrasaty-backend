<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

class RoleService
{
    /**
     * Store new role with its permissions
     */
    public function store(array $data)
    {
        $role = Role::create(['name' => $data['name']]);

        $permissions = [];
        foreach ($data['permissions'] as $group) {
            $group = array_filter($group, fn ($p) => is_bool($p) && $p == true);
            $permissions = array_merge($permissions, $group);
        }

        $role->syncPermissions(array_keys($permissions));

        return $role;
    }

    /**
     * Update role with its permissions
     */
    public function update(array $data, Role $role)
    {
        $role->update(['name' => $data['name']]);

        $permissions = [];
        foreach ($data['permissions'] as $group) {
            $group = array_filter($group, fn ($p) => is_bool($p) && $p == true);
            $permissions = array_merge($permissions, $group);
        }

        $role->syncPermissions(array_keys($permissions));
    }
}
