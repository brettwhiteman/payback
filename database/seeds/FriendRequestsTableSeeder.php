<?php

use Illuminate\Database\Seeder;

class FriendRequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('friend_requests')->insert(['from_id' => 3, 'to_id' => 1, 'hash' => hash('sha256', '1_3')]);
    }
}
