<?php

use Illuminate\Database\Seeder;

class AddBonusPercentageToBinaryStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\BinaryStructure::where(['id' => 1])
            ->update([
                'to_first_parent' => 7.14,
                'to_second_parent' => 7.14
            ]);

        \App\Models\BinaryStructure::where(['id' => 2])
            ->update([
                'to_first_parent' => 2.5,
                'to_second_parent' => 2.5
            ]);

        \App\Models\BinaryStructure::where(['id' => 3])
            ->update([
                'to_first_parent' => 2.77,
                'to_second_parent' => 2.77
            ]);

        \App\Models\BinaryStructure::where(['id' => 4])
            ->update([
                'to_first_parent' => 3.73,
                'to_second_parent' =>3.73
            ]);

        \App\Models\BinaryStructure::where(['id' => 5])
            ->update([
                'to_first_parent' => 3.04,
                'to_second_parent' => 3.04
            ]);
        \App\Models\BinaryStructure::where(['id' => 6])
            ->update([
                'to_first_parent' => 10.43,
                'to_second_parent' => 10.43
            ]);
        \App\Models\BinaryStructure::where(['id' => 7])
            ->update([
                'to_first_parent' => 8.05,
                'to_second_parent' => 8.05
            ]);

    }
}
