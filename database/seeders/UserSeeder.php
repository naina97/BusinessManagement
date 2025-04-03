<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1'); // FIXED

        $data = [
            [
                'name'       => 'Admin',
                'email'      => 'admin@gmail.com',
                'password'   => Hash::make('admin@123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Manager',
                'email'      => 'manager@gmail.com',
                'password'   => Hash::make('manager@123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'User',
                'email'      => 'user@gmail.com',
                'password'   => Hash::make('user@123'), // ✅ Fixed typo in password
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('users')->insert($data);
    }
}
