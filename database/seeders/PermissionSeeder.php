<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('permissions')->insert([

            [
                'permission_name' => 'create_user',
            ],
            [
                'permission_name' => 'update_user',
            ],
            [
                'permission_name' => 'delete_user',
            ],
            [
                'permission_name' => 'show_user',
            ],
            [
                'permission_name' => 'create_role',
            ],
            [
                'permission_name' => 'update_role',
            ],
            [
                'permission_name' => 'delete_role',
            ],
            [
                'permission_name' => 'create_permission',
            ],
            [
                'permission_name' => 'update_permission',
            ],
            [
                'permission_name' => 'delete_permission',
            ],
            
            ]);
        
    }
}
