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
            'packet_name_ru' => 'Первый стол',
            'packet_price' => 20,
            'is_show' => true,
            'sort_num' => 1,
            'packet_css_color' => 'c0c0c0',
            'packet_available_level' => 2,
            'packet_desc_ru' => 'Здесь будет подробнее описание пакета',
            'packet_thing' => '',
            'bonus_price' => 0,
            'bonus_percent' => '',
            'packet_lection' => '',
            'condition_minimum_status_id' => 0,
            'packet_status_id' => \App\Models\UserStatus::FIRST_TABLE,
            'is_upgrade_packet' => false,
        ]);
        \App\Models\Packet::create([
            'packet_id' => 2,
            'packet_name_ru' => 'Второй стол',
            'packet_price' => 72,
            'is_show' => true,
            'sort_num' => 2,
            'packet_css_color' => 'ffd700',
            'packet_available_level' => 2,
            'packet_desc_ru' => 'Здесь будет подробнее описание пакета',
            'packet_thing' => '',
            'bonus_price' => 0,
            'bonus_percent' => '',
            'packet_lection' => '',
            'condition_minimum_status_id' => \App\Models\UserStatus::SECOND_TABLE,
            'packet_status_id' => \App\Models\UserStatus::SECOND_TABLE,
            'is_upgrade_packet' => false,
        ]);

        \App\Models\Packet::create([
            'packet_id' => 3,
            'packet_name_ru' => 'Третий стол',
            'packet_price' => 144,
            'is_show' => true,
            'sort_num' => 3,
            'packet_css_color' => 'e5e4e2',
            'packet_available_level' => 2,
            'packet_desc_ru' => 'Здесь будет подробнее описание пакета',
            'packet_thing' => '',
            'bonus_price' => 0,
            'bonus_percent' => '',
            'packet_lection' => '',
            'condition_minimum_status_id' => \App\Models\UserStatus::THIRD_TABLE,
            'packet_status_id' => \App\Models\UserStatus::THIRD_TABLE,
            'is_upgrade_packet' => false,
        ]);

        \App\Models\Packet::create([
            'packet_id' => 4,
            'packet_name_ru' => 'Четвертый стол',
            'packet_price' => 476,
            'is_show' => true,
            'sort_num' => 4,
            'packet_css_color' => 'ca0147',
            'packet_available_level' => 2,
            'packet_desc_ru' => 'Здесь будет подробнее описание пакета',
            'packet_thing' => '',
            'bonus_price' => 0,
            'bonus_percent' => '',
            'packet_lection' => '',
            'condition_minimum_status_id' => \App\Models\UserStatus::FOURTH_TABLE,
            'packet_status_id' => \App\Models\UserStatus::FOURTH_TABLE,
            'is_upgrade_packet' => false,
        ]);

        \App\Models\Packet::create([
            'packet_id' => 5,
            'packet_name_ru' => 'Пятый стол',
            'packet_price' => 932,
            'is_show' => true,
            'sort_num' => 5,
            'packet_css_color' => 'DB8C28',
            'packet_available_level' => 2,
            'packet_desc_ru' => 'Здесь будет подробнее описание пакета',
            'packet_thing' => '',
            'bonus_price' => 0,
            'bonus_percent' => '',
            'packet_lection' => '',
            'condition_minimum_status_id' => \App\Models\UserStatus::FIFTH_TABLE,
            'packet_status_id' => \App\Models\UserStatus::FIFTH_TABLE,
            'is_upgrade_packet' => false,
        ]);
    }
}
