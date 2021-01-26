<?php

use App\Models\Users;
use Illuminate\Database\Seeder;

class PrepareDatabaseBeforeTestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = \App\Models\Users::all();

        foreach ($users as $user) {
            $user->user_money = 0;
            $user->save();
        }
    }
}