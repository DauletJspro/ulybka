<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertVipBinaryStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('binary_structures')->insert([
            'id' => 6,
            'name' => 'first_structure_vip',
            'name_ru' => 'Первый стол VIP',
            'type' => 'first_structure_vip',
            'tree_representation' => null,
            'view_type' => 1,
            'to_first_parent' => 0,
            'to_second_parent' => 10,
            'prime_when_closed_structure' => 0,
            'check_from_check_percentage' => 0,
            'css_color' => '#c0c0c0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('binary_structures')->insert([
            'id' => 7,
            'name' => 'second_structure_vip',
            'name_ru' => 'Второй стол VIP',
            'type' => 'second_structure_vip',
            'tree_representation' => null,
            'view_type' => 2,
            'to_first_parent' => 0,
            'to_second_parent' => 0,
            'prime_when_closed_structure' => 0,
            'check_from_check_percentage' => 0,
            'css_color' => '#c0c0c0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('binary_structures')->insert([
            'id' => 8,
            'name' => 'third_structure_vip',
            'name_ru' => 'Третий стол VIP',
            'type' => 'third_structure_vip',
            'tree_representation' => null,
            'view_type' => 1,
            'to_first_parent' => 0,
            'to_second_parent' => 13.8,
            'prime_when_closed_structure' => 0,
            'check_from_check_percentage' => 0,
            'css_color' => '#c0c0c0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('binary_structures')->insert([
            'id' => 9,
            'name' => 'fourth_structure_vip',
            'name_ru' => 'Четвертый стол VIP',
            'type' => 'fourth_structure_vip',
            'tree_representation' => null,
            'view_type' => 2,
            'to_first_parent' => 0,
            'to_second_parent' => 0,
            'prime_when_closed_structure' => 0,
            'check_from_check_percentage' => 0,
            'css_color' => '#c0c0c0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('binary_structures')->insert([
            'id' => 10,
            'name' => 'fifth_structure_vip',
            'name_ru' => 'Пятый стол VIP',
            'type' => 'fifth_structure_vip',
            'tree_representation' => null,
            'view_type' => 1,
            'to_first_parent' => 53.6,
            'to_second_parent' => 2.14,
            'prime_when_closed_structure' => 0,
            'check_from_check_percentage' => 0,
            'css_color' => '#c0c0c0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
