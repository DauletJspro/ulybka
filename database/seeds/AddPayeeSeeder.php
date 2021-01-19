<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AddPayeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = (date('Y-m-d H:i:s'));
        try {
            DB::beginTransaction();
            \App\Models\Users::create(
                [
                    'user_id' => 2000,
                    'name' => 'Fond',
                    'phone' => +7777777777,
                    'email' => 'fond.kz@gmail.com',
                    'avatar' => '/media/default.png',
                    'role_id' => 2,
                    'is_interest_holder' => 0,
                    'share' => 0,
                    'password' => Hash::make('ulybka_2020'),
                    'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'remember_token' => '',
                    'is_ban' => 0,
                    'last_name' => 'Фонд',
                    'middle_name' => '',
                    'recommend_user_id' => 1,
                    'city_id' => 0,
                    'user_money' => 0,
                    'office_director_id' => null,
                    'login' => 'Fond',
                    'office_name' => '',
                    'hash_email' => '',
                    'is_confirm_email' => 1,
                    'status_id' => 0,
                    'is_activated' => 1,
                    'activated_date' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'instagram' => '',
                ]
            );
            \App\Models\Users::create(
                [
                    'user_id' => 2001,
                    'name' => 'Oreke',
                    'phone' => +7777777777,
                    'email' => 'Oreke.kz@gmail.com',
                    'avatar' => '/media/default.png',
                    'role_id' => 2,
                    'is_interest_holder' => 0,
                    'share' => 0,
                    'password' => Hash::make('ulybka_2020'),
                    'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'remember_token' => '',
                    'is_ban' => 0,
                    'last_name' => 'Ореке',
                    'middle_name' => '',
                    'recommend_user_id' => 1,
                    'city_id' => 0,
                    'user_money' => 0,
                    'office_director_id' => null,
                    'login' => 'Oreke',
                    'office_name' => '',
                    'hash_email' => '',
                    'is_confirm_email' => 1,
                    'status_id' => 0,
                    'is_activated' => 1,
                    'activated_date' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'instagram' => '',
                ]
            );
            \App\Models\Users::create(
                [
                    'user_id' => 2002,
                    'name' => 'Make',
                    'phone' => +7777777777,
                    'email' => 'Make.kz@gmail.com',
                    'avatar' => '/media/default.png',
                    'role_id' => 2,
                    'is_interest_holder' => 0,
                    'share' => 0,
                    'password' => Hash::make('ulybka_2020'),
                    'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'remember_token' => '',
                    'is_ban' => 0,
                    'last_name' => 'Make',
                    'middle_name' => '',
                    'recommend_user_id' => 1,
                    'city_id' => 0,
                    'user_money' => 0,
                    'office_director_id' => null,
                    'login' => 'Make',
                    'office_name' => '',
                    'hash_email' => '',
                    'is_confirm_email' => 1,
                    'status_id' => 0,
                    'is_activated' => 1,
                    'activated_date' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'instagram' => '',
                ]
            );
            DB::commit();
        } catch (Exception $exception) {
            var_dump($exception->getMessage());
            DB::rollback();
        }
    }
}
