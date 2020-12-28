<?php

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
            $user->product_balance = 0;
            $user->status_id = 0;
            $user->password = \Illuminate\Support\Facades\Hash::make('123456');
            $user->save();
        }
    }
}
