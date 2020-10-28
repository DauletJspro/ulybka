<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddPacketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('packet')->truncate();
        \App\Models\Packet::create([
            'packet_id' => 1,
            'packet_name_ru' => 'Silver',
            'packet_price' => 24,
            'is_show' => true,
            'sort_num' => 1,
            'packet_css_color' => '55b83f',
            'packet_available_level' => 2,
            'packet_desc_ru' => 'Здесь будет подробнее описание пакета',
            'packet_thing' => '',
            'bonus_price' => 0,
            'bonus_percent' => '',
            'packet_lection' => '',
            'condition_minimum_status_id' => 0,            
            'packet_status_id' => \App\Models\UserStatus::SILVER,
            'is_upgrade_packet' => false,
        ]);
        \App\Models\Packet::create([
            'packet_id' => 2,
            'packet_name_ru' => 'Gold',
            'packet_price' => 48,
            'is_show' => true,
            'sort_num' => 2,
            'packet_css_color' => '2285E3',
            'packet_available_level' => 2,
            'packet_desc_ru' => 'Здесь будет подробнее описание пакета',
            'packet_thing' => '',
            'bonus_price' => 0,
            'bonus_percent' => '',
            'packet_lection' => '',
            'condition_minimum_status_id' => \App\Models\UserStatus::GOLD,
            'packet_status_id' => \App\Models\UserStatus::GOLD,
            'is_upgrade_packet' => false,
        ]);

        \App\Models\Packet::create([
            'packet_id' => 3,
            'packet_name_ru' => 'Platinum',
            'packet_price' => 152,
            'is_show' => true,
            'sort_num' => 3,
            'packet_css_color' => 'FE408A',
            'packet_available_level' => 2,
            'packet_desc_ru' => 'Здесь будет подробнее описание пакета',
            'packet_thing' => '',
            'bonus_price' => 100,
            'bonus_percent' => '',
            'packet_lection' => '',
            'condition_minimum_status_id' => \App\Models\UserStatus::PLATINUM,
            'packet_status_id' => \App\Models\UserStatus::PLATINUM,
            'is_upgrade_packet' => false,
        ]);

        \App\Models\Packet::create([
            'packet_id' => 4,
            'packet_name_ru' => 'Rubin',
            'packet_price' => 544,
            'is_show' => true,
            'sort_num' => 4,
            'packet_css_color' => 'FFD700',
            'packet_available_level' => 2,
            'packet_desc_ru' => 'Здесь будет подробнее описание пакета',
            'packet_thing' => '',
            'bonus_price' => 500,
            'bonus_percent' => '',
            'packet_lection' => '',
            'condition_minimum_status_id' => \App\Models\UserStatus::RUBIN,
            'packet_status_id' => \App\Models\UserStatus::RUBIN,
            'is_upgrade_packet' => false,
        ]);

        \App\Models\Packet::create([
            'packet_id' => 5,
            'packet_name_ru' => 'Sapphire',
            'packet_price' => 1324,
            'is_show' => true,
            'sort_num' => 4,
            'packet_css_color' => 'DB8C28',
            'packet_available_level' => 2,
            'packet_desc_ru' => 'Здесь будет подробнее описание пакета',
            'packet_thing' => '',
            'bonus_price' => 700,
            'bonus_percent' => '',
            'packet_lection' => '',
            'condition_minimum_status_id' => \App\Models\UserStatus::SAPPHIRE,
            'packet_status_id' => \App\Models\UserStatus::SAPPHIRE,
            'is_upgrade_packet' => false,
        ]);

        \App\Models\Packet::create([
            'packet_id' => 6,
            'packet_name_ru' => 'Emerald',
            'packet_price' => 3844,
            'is_show' => true,
            'sort_num' => 5,
            'packet_css_color' => 'CC9966',
            'packet_available_level' => 2,
            'packet_desc_ru' => 'Здесь будет подробнее описание пакета',
            'packet_thing' => '',
            'bonus_price' => 2000,
            'bonus_percent' => '',
            'packet_lection' => '',
            'condition_minimum_status_id' => \App\Models\UserStatus::EMERALD,
            'packet_status_id' => \App\Models\UserStatus::EMERALD,
            'is_upgrade_packet' => false,
        ]);

        \App\Models\Packet::create([
            'packet_id' => 7,
            'packet_name_ru' => 'Diamond',
            'packet_price' => 9744,
            'is_show' => true,
            'sort_num' => 6,
            'packet_css_color' => '06A588',
            'packet_available_level' => 2,
            'packet_desc_ru' => 'Здесь будет подробнее описание пакета',
            'packet_thing' => '',
            'bonus_price' => 20000,
            'bonus_percent' => '',
            'packet_lection' => '',
            'condition_minimum_status_id' => \App\Models\UserStatus::DIAMOND,
            'packet_status_id' => \App\Models\UserStatus::DIAMOND,
            'is_upgrade_packet' => false,
        ]);
    }
}
