<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AddAdminsToUsers extends Seeder
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
                    'user_id' => 1,
                    'name' => 'Admin',
                    'phone' => +77716742555,
                    'email' => 'admin.kz@gmail.com',
                    'avatar' => '/media/default.png',
                    'role_id' => 1,
                    'is_interest_holder' => 0,
                    'share' => 0,
                    'password' => Hash::make('62Admin001001001'),
                    'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s',$now),
                    'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'remember_token' => '',
                    'is_ban' => 0,
                    'last_name' => 'Админ',
                    'middle_name' => '',
                    'recommend_user_id' => 0,
                    'city_id' => 2,
                    'user_money' => 0,
                    'office_director_id' => null,
                    'login' => 'admin',
                    'office_name' => '',
                    'hash_email' => '',
                    'is_confirm_email' => 1,
                    'status_id' => 7,
                    'is_activated' => 1,
                    'activated_date' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'parent_id' => 0,
                    'instagram' => '',
                ]
            );
            \App\Models\Users::create(
                [
                    'user_id' => 2,
                    'name' => 'Admin1',
                    'phone' => +77716742555,
                    'email' => 'admin1.kz@gmail.com',
                    'avatar' => '/media/default.png',
                    'role_id' => 2,
                    'is_interest_holder' => 0,
                    'share' => 0,
                    'password' => Hash::make('62Admin1001001001'),
                    'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s',$now),
                    'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'remember_token' => '',
                    'is_ban' => 0,
                    'last_name' => 'Админ1',
                    'middle_name' => '',
                    'recommend_user_id' => 1,
                    'city_id' => 2,
                    'user_money' => 0,
                    'office_director_id' => null,
                    'login' => 'admin1',
                    'office_name' => '',
                    'hash_email' => '',
                    'is_confirm_email' => 1,
                    'status_id' => 7,
                    'is_activated' => 1,
                    'activated_date' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'parent_id' => 1,
                    'instagram' => '',
                ]
            );
            \App\Models\Users::create(
                [
                    'user_id' => 3,
                    'name' => 'Admin2',
                    'phone' => +77716742555,
                    'email' => 'admin2.kz@gmail.com',
                    'avatar' => '/media/default.png',
                    'role_id' => 2,
                    'is_interest_holder' => 0,
                    'share' => 0,
                    'password' => Hash::make('62Admin2001001001'),
                    'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s',$now),
                    'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'remember_token' => '',
                    'is_ban' => 0,
                    'last_name' => 'Админ2',
                    'middle_name' => '',
                    'recommend_user_id' => 2,
                    'city_id' => 2,
                    'user_money' => 0,
                    'office_director_id' => null,
                    'login' => 'admin2',
                    'office_name' => '',
                    'hash_email' => '',
                    'is_confirm_email' => 1,
                    'status_id' => 7,
                    'is_activated' => 1,
                    'activated_date' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'parent_id' => 2,
                    'instagram' => '',
                ]
            );
            \App\Models\Users::create(
                [
                    'user_id' => 4,
                    'name' => 'Admin3',
                    'phone' => +77716742555,
                    'email' => 'admin3.kz@gmail.com',
                    'avatar' => '/media/default.png',
                    'role_id' => 2,
                    'is_interest_holder' => 0,
                    'share' => 0,
                    'password' => Hash::make('62Admin301001001'),
                    'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s',$now),
                    'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'remember_token' => '',
                    'is_ban' => 0,
                    'last_name' => 'Админ3',
                    'middle_name' => '',
                    'recommend_user_id' => 3,
                    'city_id' => 2,
                    'user_money' => 0,
                    'office_director_id' => null,
                    'login' => 'admin3',
                    'office_name' => '',
                    'hash_email' => '',
                    'is_confirm_email' => 1,
                    'status_id' => 7,
                    'is_activated' => 1,
                    'activated_date' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'parent_id' => 3,
                    'instagram' => '',
                ]
            );
            \App\Models\Users::create(
                [
                    'user_id' => 5,
                    'name' => 'Admin4',
                    'phone' => +77716742555,
                    'email' => 'admin4.kz@gmail.com',
                    'avatar' => '/media/default.png',
                    'role_id' => 2,
                    'is_interest_holder' => 0,
                    'share' => 0,
                    'password' => Hash::make('62Admin4001001001'),
                    'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'remember_token' => '',
                    'is_ban' => 0,
                    'last_name' => 'Админ4',
                    'middle_name' => '',
                    'recommend_user_id' => 4,
                    'city_id' => 2,
                    'user_money' => 0,
                    'office_director_id' => null,
                    'login' => 'admin4',
                    'office_name' => '',
                    'hash_email' => '',
                    'is_confirm_email' => 1,
                    'status_id' => 7,
                    'is_activated' => 1,
                    'activated_date' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'parent_id' => 4,
                    'instagram' => '',

                ]
            );
            \App\Models\Users::create(
                [
                    'user_id' => 6,
                    'name' => 'Admin5',
                    'phone' => +77716742555,
                    'email' => 'admin5.kz@gmail.com',
                    'avatar' => '/media/default.png',
                    'role_id' => 2,
                    'is_interest_holder' => 0,
                    'share' => 0,
                    'password' => Hash::make('62Admin5001001001'),
                    'updated_at' =>  Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'remember_token' => '',
                    'is_ban' => 0,
                    'last_name' => 'Админ5',
                    'middle_name' => '',
                    'recommend_user_id' => 5,
                    'city_id' => 2,
                    'user_money' => 0,
                    'office_director_id' => null,
                    'login' => 'admin5',
                    'office_name' => '',
                    'hash_email' => '',
                    'is_confirm_email' => 1,
                    'status_id' => 7,
                    'is_activated' => 1,
                    'activated_date' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'parent_id' => 5,
                    'instagram' => '',

                ]
            );
            \App\Models\Users::create(
                [
                    'user_id' => 7,
                    'name' => 'Admin6',
                    'phone' => +77716742555,
                    'email' => 'admin6.kz@gmail.com',
                    'avatar' => '/media/default.png',
                    'role_id' => 2,
                    'is_interest_holder' => 0,
                    'share' => 0,
                    'password' => Hash::make('62Admin6001001001'),
                    'updated_at' =>  Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'remember_token' => '',
                    'is_ban' => 0,
                    'last_name' => 'Админ6',
                    'middle_name' => '',
                    'recommend_user_id' => 6,
                    'city_id' => 2,
                    'user_money' => 0,
                    'office_director_id' => null,
                    'login' => 'admin6',
                    'office_name' => '',
                    'hash_email' => '',
                    'is_confirm_email' => 1,
                    'status_id' => 7,
                    'is_activated' => 1,
                    'activated_date' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'parent_id' => 1000,
                    'instagram' => '',

                ]
            );
            \App\Models\Users::create(
                [
                    'user_id' => 8,
                    'name' => 'Admin7',
                    'phone' => +77716742555,
                    'email' => 'admin7.kz@gmail.com',
                    'avatar' => '/media/default.png',
                    'role_id' => 2,
                    'is_interest_holder' => 0,
                    'share' => 0,
                    'password' => Hash::make('62Admin7001001001'),
                    'updated_at' =>  Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'remember_token' => '',
                    'is_ban' => 0,
                    'last_name' => 'Админ7',
                    'middle_name' => '',
                    'recommend_user_id' => 7,
                    'city_id' => 2,
                    'user_money' => 0,
                    'office_director_id' => null,
                    'login' => 'admin7',
                    'office_name' => '',
                    'hash_email' => '',
                    'is_confirm_email' => 1,
                    'status_id' => 7,
                    'is_activated' => 1,
                    'activated_date' => Carbon::createFromFormat('Y-m-d H:i:s', $now),
                    'parent_id' => 1001,
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
