<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'system_admin',
                'description' => 'All permission',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'admin',
                'description' => 'All permission, except: roles-table, permission-table, cant not edit user with role is admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'editor',
                'description' => 'Editor only create, edit, delete contents',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'customer',
                'description' => 'Only view, write comment, like',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('permissions')->insert([
            ['name' => 'review_post', 'description' => '', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'update_post', 'description' => '', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_post', 'description' => '', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'restore_post', 'description' => '', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'force_delete_post', 'description' => '', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('role_permission')->insert([
            ['permission_id' => 1, 'role_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 2, 'role_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 3, 'role_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 4, 'role_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 5, 'role_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
