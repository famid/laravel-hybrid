<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'first_name' => "Mr.",
                'last_name' => "Admin",
                'email' => "admin@gmail.com",
                'password' => Hash::make('1234'),
                'role' => ADMIN_ROLE
            ],
            [
                'first_name' => "Mr.",
                'last_name' => "user1",
                'email' => "user1@gmail.com",
                'password' => Hash::make('1234'),
                'role' => USER_ROLE

            ],
            [
                'first_name' => "Mr.",
                'last_name' => "user2",
                'email' => "user2@gmail.com",
                'password' => Hash::make('1234'),
                'role' => USER_ROLE
            ],

        ]);
    }
}
