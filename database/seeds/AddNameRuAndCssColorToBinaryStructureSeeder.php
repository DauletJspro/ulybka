<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddNameRuAndCssColorToBinaryStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('binary_structures')
            ->where(['id' => \App\Models\Packet::SILVER])
            ->update([
                'name_ru' => 'Серебряный стол',
                'css_color' => '#c0c0c0',
            ]);

        DB::table('binary_structures')
            ->where(['id' => \App\Models\Packet::GOLD])
            ->update([
                'name_ru' => 'Золотой стол',
                'css_color' => '#ffd700',
            ]);

        DB::table('binary_structures')
            ->where(['id' => \App\Models\Packet::PLATINUM])
            ->update([
                'name_ru' => 'Платиновый стол',
                'css_color' => '#e5e4e2',
            ]);

        DB::table('binary_structures')
            ->where(['id' => \App\Models\Packet::RUBIN])
            ->update([
                'name_ru' => 'Рубиновый стол',
                'css_color' => '#ca0147',
            ]);

        DB::table('binary_structures')
            ->where(['id' => \App\Models\Packet::SAPPHIRE])
            ->update([
                'name_ru' => 'Cапфировый стол',
                'css_color' => '#363b5b',
            ]);

        DB::table('binary_structures')
            ->where(['id' => \App\Models\Packet::EMERALD])
            ->update([
                'name_ru' => 'Изумруд стол',
                'css_color' => '#50c878',
            ]);

        DB::table('binary_structures')
            ->where(['id' => \App\Models\Packet::DIAMOND])
            ->update([
                'name_ru' => 'Бриллиантовый стол',
                'css_color' => '#b9f2ff',
            ]);

    }
}
