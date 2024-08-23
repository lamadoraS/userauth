<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Define roles with their respective role IDs
        $roles = [
            'admin' => 1,
            'regular_user' => 2,
            'api_consumer' => 3,
            'guest' => 4,
        ];

        // Define permissions with their respective permission IDs
        $permissions = [
            'create_user' => 1,
            'update_user' => 2,
            'delete_user' => 3,
            'show_user' => 4,
            'create_role' => 5,
            'update_role' => 6,
            'delete_role' => 7,
            'create_permission' => 8,
            'update_permission' => 9,
            'delete_permission' => 10,
        ];

        // Admin has all permissions
        foreach ($permissions as $permission => $permissionId) {
            DB::table('role_permissions')->insert([
                'role_id' => $roles['admin'],
                'permission_id' => $permissionId,
            ]);
        }

        // Regular User, API Consumer, and Guest have limited permissions
        $limitedPermissions = [
            'update_user',
            'delete_user',
            'show_user',
        ];

        foreach (['regular_user', 'api_consumer', 'guest'] as $role) {
            foreach ($limitedPermissions as $permission) {
                DB::table('role_permissions')->insert([
                    'role_id' => $roles[$role],
                    'permission_id' => $permissions[$permission],
                ]);
            }
        }
    }
}