<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CleanAndAddStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_status')->truncate();

        \App\Models\UserStatus::create([
            'user_status_id' => \App\Models\UserStatus::SILVER,
            'user_status_name' => 'silver',
            'user_status_money' => 0,
            'user_status_available_level' => 0,
            'sort_num' => 1,
            'is_show' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        \App\Models\UserStatus::create([
            'user_status_id' => \App\Models\UserStatus::GOLD,
            'user_status_name' => 'gold',
            'user_status_money' => 0,
            'user_status_available_level' => 0,
            'sort_num' => 2,
            'is_show' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        \App\Models\UserStatus::create([
            'user_status_id' => \App\Models\UserStatus::PLATINUM,
            'user_status_name' => 'platinum',
            'user_status_money' => 0,
            'user_status_available_level' => 0,
            'sort_num' => 3,
            'is_show' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        \App\Models\UserStatus::create([
            'user_status_id' => \App\Models\UserStatus::RUBIN,
            'user_status_name' => 'rubin',
            'user_status_money' => 0,
            'user_status_available_level' => 0,
            'sort_num' => 4,
            'is_show' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        \App\Models\UserStatus::create([
            'user_status_id' => \App\Models\UserStatus::SAPPHIRE,
            'user_status_name' => 'sapphire',
            'user_status_money' => 0,
            'user_status_available_level' => 0,
            'sort_num' => 5,
            'is_show' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        \App\Models\UserStatus::create([
            'user_status_id' => \App\Models\UserStatus::EMERALD,
            'user_status_name' => 'emerald',
            'user_status_money' => 0,
            'user_status_available_level' => 0,
            'sort_num' => 6,
            'is_show' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        \App\Models\UserStatus::create([
            'user_status_id' => \App\Models\UserStatus::DIAMOND,
            'user_status_name' => 'diamond',
            'user_status_money' => 0,
            'user_status_available_level' => 0,
            'sort_num' => 7,
            'is_show' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);        
    }
}
