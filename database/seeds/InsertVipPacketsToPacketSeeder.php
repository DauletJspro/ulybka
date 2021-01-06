<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertVipPacketsToPacketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('packet')
            ->insert([
                'packet_id' => 6,
                'packet_name_ru' => 'Первый стол VIP',
                'packet_price' => 100,
                'is_show' => true,
                'sort_num' => 6,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'packet_css_color' => 'ffd700',
                'packet_available_level' => 0,
                'bonus_price' => 0,
                'packet_desc_ru' => 'Здесь будет подробнее описание пакета',
                'speaker_procent' => 0,
                'is_portfolio' => 0,
                'packet_status_id' => 6,
                'packet_type' => 1,
                'is_auto' => 0,
                'packet_status_money' => 0,
                'is_recruite_profit' => 0,
                'is_usual_packet' => 0,
                'is_upgrade_packet' => 0,
                'condition_minimum_status_id' => 6,
                'is_old' => 0,
                'pv' => 0,
            ]);

        DB::table('packet')
            ->insert([
                'packet_id' => 7,
                'packet_name_ru' => 'Второй стол VIP',
                'packet_price' => 360,
                'is_show' => true,
                'sort_num' => 7,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'packet_css_color' => 'ffd700',
                'packet_available_level' => 0,
                'bonus_price' => 0,
                'packet_desc_ru' => 'Здесь будет подробнее описание пакета',
                'speaker_procent' => 0,
                'is_portfolio' => 0,
                'packet_status_id' => 7,
                'packet_type' => 1,
                'is_auto' => 0,
                'packet_status_money' => 0,
                'is_recruite_profit' => 0,
                'is_usual_packet' => 0,
                'is_upgrade_packet' => 0,
                'condition_minimum_status_id' => 7,
                'is_old' => 0,
                'pv' => 0,
            ]);

        DB::table('packet')
            ->insert([
                'packet_id' => 8,
                'packet_name_ru' => 'Третий стол VIP',
                'packet_price' => 720,
                'is_show' => true,
                'sort_num' => 8,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'packet_css_color' => 'ffd700',
                'packet_available_level' => 0,
                'bonus_price' => 0,
                'packet_desc_ru' => 'Здесь будет подробнее описание пакета',
                'speaker_procent' => 0,
                'is_portfolio' => 0,
                'packet_status_id' => 8,
                'packet_type' => 1,
                'is_auto' => 0,
                'packet_status_money' => 0,
                'is_recruite_profit' => 0,
                'is_usual_packet' => 0,
                'is_upgrade_packet' => 0,
                'condition_minimum_status_id' => 8,
                'is_old' => 0,
                'pv' => 0,
            ]);

        DB::table('packet')
            ->insert([
                'packet_id' => 9,
                'packet_name_ru' => 'Четвертый стол VIP',
                'packet_price' => 2380,
                'is_show' => true,
                'sort_num' => 9,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'packet_css_color' => 'ffd700',
                'packet_available_level' => 0,
                'bonus_price' => 0,
                'packet_desc_ru' => 'Здесь будет подробнее описание пакета',
                'speaker_procent' => 0,
                'is_portfolio' => 0,
                'packet_status_id' => 9,
                'packet_type' => 1,
                'is_auto' => 0,
                'packet_status_money' => 0,
                'is_recruite_profit' => 0,
                'is_usual_packet' => 0,
                'is_upgrade_packet' => 0,
                'condition_minimum_status_id' => 9,
                'is_old' => 0,
                'pv' => 0,
            ]);

        DB::table('packet')
            ->insert([
                'packet_id' => 10,
                'packet_name_ru' => 'Пятый стол VIP',
                'packet_price' => 4660,
                'is_show' => true,
                'sort_num' => 10,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'packet_css_color' => 'ffd700',
                'packet_available_level' => 0,
                'bonus_price' => 0,
                'packet_desc_ru' => 'Здесь будет подробнее описание пакета',
                'speaker_procent' => 0,
                'is_portfolio' => 0,
                'packet_status_id' => 10,
                'packet_type' => 1,
                'is_auto' => 0,
                'packet_status_money' => 0,
                'is_recruite_profit' => 0,
                'is_usual_packet' => 0,
                'is_upgrade_packet' => 0,
                'condition_minimum_status_id' => 10,
                'is_old' => 0,
                'pv' => 0,
            ]);
    }
}
