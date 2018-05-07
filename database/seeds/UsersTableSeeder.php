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
        App\Models\User::create(['name' => 'John Smith', 'email' => 'john@example.com', 'password' => bcrypt('secret')]);
        App\Models\User::create(['name' => 'Steve Smith', 'email' => 'steve@example.com', 'password' => bcrypt('secret')]);
        App\Models\User::create(['name' => 'Alan Smith', 'email' => 'alan@example.com', 'password' => bcrypt('secret')]);
    }
}
