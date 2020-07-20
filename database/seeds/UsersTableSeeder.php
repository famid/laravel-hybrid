<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'name' => "admin",
                'email' => "admin@gmail.com",
                'password' => \Illuminate\Support\Facades\Hash::make('1234')
            ],
            [
                'name' => "user1",
                'email' => "user1@gmail.com",
                'password' => \Illuminate\Support\Facades\Hash::make('1234')
            ],
            [
                'name' => "user2",
                'email' => "user2@gmail.com",
                'password' => \Illuminate\Support\Facades\Hash::make('1234')
            ],

        ]);
    }
}
