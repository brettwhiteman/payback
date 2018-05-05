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
        App\User::create(['name' => 'John Smith', 'email' => 'john@example.com', 'password' => bcrypt('secret')]);
        App\User::create(['name' => 'Steve Smith', 'email' => 'steve@example.com', 'password' => bcrypt('secret')]);
        App\User::create(['name' => 'Alan Smith', 'email' => 'alan@example.com', 'password' => bcrypt('secret')]);
    }
}
