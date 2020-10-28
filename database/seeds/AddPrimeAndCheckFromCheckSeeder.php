<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddPrimeAndCheckFromCheckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('binary_structures')->where(['id' => \App\Models\Packet::RUBIN])
            ->update([
                'prime_when_closed_structure' => 600,
                'check_from_check_percentage' => 5,
            ]);

        DB::table('binary_structures')->where(['id' => \App\Models\Packet::SAPPHIRE])
            ->update([
                'prime_when_closed_structure' => 1000,
                'check_from_check_percentage' => 5,
            ]);

        DB::table('binary_structures')->where(['id' => \App\Models\Packet::EMERALD])
            ->update([
                'prime_when_closed_structure' => 2000,
                'check_from_check_percentage' => 5,
            ]);

        DB::table('binary_structures')->where(['id' => \App\Models\Packet::DIAMOND])
            ->update([
                'prime_when_closed_structure' => 20000,
                'check_from_check_percentage' => 5,
            ]);
    }
}
