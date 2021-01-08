<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'id' => 1,
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role_id' => 1,
            'password' => bcrypt('12312310'),
            'phone' => '0123456789',
            'remember_token' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
