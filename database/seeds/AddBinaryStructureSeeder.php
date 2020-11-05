<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddBinaryStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('binary_structures')->truncate();
        DB::table('binary_structures')->insert([
            'name' => 'first_structure',
            'name_ru' => 'Первый стол',
            'type' => 'first_structure',
            'tree_representation' => null,
            'view_type' => 1,
            'to_first_parent' => 10,
            'to_second_parent' => 0,
            'prime_when_closed_structure' => 0,
            'check_from_check_percentage' => 0,
            'css_color' => '#c0c0c0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('binary_structures')->insert([
            'name' => 'second_structure',
            'name_ru' => 'Второй стол',
            'type' => 'second_structure',
            'tree_representation' => null,
            'view_type' => 2,
            'to_first_parent' => 0,
            'to_second_parent' => 0,
            'prime_when_closed_structure' => 0,
            'check_from_check_percentage' => 0,
            'css_color' => '#ffd700',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('binary_structures')->insert([
            'name' => 'third_structure',
            'name_ru' => 'Третий стол',
            'type' => 'third_structure',
            'tree_representation' => null,
            'view_type' => 1,
            'to_first_parent' => 13.8,
            'to_second_parent' => 0,
            'prime_when_closed_structure' => 0,
            'check_from_check_percentage' => 0,
            'css_color' => '#e5e4e2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('binary_structures')->insert([
            'name' => 'fourth_structure',
            'name_ru' => 'Четвёртый стол',
            'type' => 'fourth_structure',
            'tree_representation' => null,
            'view_type' => 2,
            'to_first_parent' => 0,
            'to_second_parent' => 0,
            'prime_when_closed_structure' => 0,
            'check_from_check_percentage' => 0,
            'css_color' => '#ca0147',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('binary_structures')->insert([
            'name' => 'fifth_structure',
            'name_ru' => 'Пятый стол',
            'type' => 'fifth_structure',
            'tree_representation' => null,
            'view_type' => 1,
            'to_first_parent' => 2.14,
            'to_second_parent' => 5.36,
            'prime_when_closed_structure' => 0,
            'check_from_check_percentage' => 0,
            'css_color' => '#363b5b',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
