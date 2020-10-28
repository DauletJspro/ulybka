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
            'name' => 'Silver',
            'type' => 'first_structure',
        ]);
        DB::table('binary_structures')->insert([
            'name' => 'Gold',
            'type' => 'second_structure',
        ]);
        DB::table('binary_structures')->insert([
            'name' => 'Platinum',
            'type' => 'third_structure',
        ]);
        DB::table('binary_structures')->insert([
            'name' => 'Rubin',
            'type' => 'fourth_structure',
        ]);
        DB::table('binary_structures')->insert([
            'name' => 'Sapphire',
            'type' => 'fifth_structure',
        ]);
        DB::table('binary_structures')->insert([
            'name' => 'Emerald',
            'type' => 'sixth_structure',
        ]);
        DB::table('binary_structures')->insert([
            'name' => 'Diamond',
            'type' => 'seventh_structure',
        ]);
    }
}
