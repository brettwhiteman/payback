<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(['name' => 'John Smith', 'email' => 'john@example.com', 'password' => bcrypt('secret')]);
        DB::table('users')->insert(['name' => 'Steve Smith', 'email' => 'steve@example.com', 'password' => bcrypt('secret')]);
        DB::table('users')->insert(['name' => 'Alan Smith', 'email' => 'alan@example.com', 'password' => bcrypt('secret')]);
    }
}
