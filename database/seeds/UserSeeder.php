<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name' => 'amr',
            'email' => 'amr@gmail.com',
            'password' => Hash::make(123123123)


        ]);


        DB::table('users')->insert([
            'name' => 'noura',
            'email' => 'noura@gmail.com',
            'password' => Hash::make(123123123)


        ]);

    }
}
