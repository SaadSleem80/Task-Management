<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'manager' => [
                'task:read',
                'task:create',
                'task:update',
                'task:assign',
                'task:delete'
            ],
            'user' => [
                'task:read',
                'task:update',
            ]
        ];

        $permissions = [
            'task' => [
                'task:read',
                'task:create',
                'task:update',
                'task:assign',
                'task:delete'
            ]
        ];

        
        foreach($permissions as $permission) {
            foreach($permission as $subPermission) {
                Permission::create(['name' => $subPermission]);
            }
        }
        
        foreach($roles as $key => $permissions) {
            $role = Role::create(['name' => $key]);

            $role->givePermissionTo($permissions);
        }
    }
}
