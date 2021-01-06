<?php

use Illuminate\Database\Seeder;

class UnitTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            (app(\App\Models\TreeImplementation::class)->thirdStructure(11,1,true));
            (app(\App\Models\TreeImplementation::class)->thirdStructure(10,1,true));
            (app(\App\Models\TreeImplementation::class)->thirdStructure(12,1,true));
            (app(\App\Models\TreeImplementation::class)->thirdStructure(16,1,true));
            (app(\App\Models\TreeImplementation::class)->thirdStructure(14,1,true));
            (app(\App\Models\TreeImplementation::class)->thirdStructure(15,1,true));
            (app(\App\Models\TreeImplementation::class)->thirdStructure(17,1,true));
            (app(\App\Models\TreeImplementation::class)->thirdStructure(18,1,true));
            (app(\App\Models\TreeImplementation::class)->thirdStructure(19,1,true));
            (app(\App\Models\TreeImplementation::class)->thirdStructure(20,1,true));
            (app(\App\Models\TreeImplementation::class)->thirdStructure(21,1,true));
            (app(\App\Models\TreeImplementation::class)->thirdStructure(22,1,true));
            (app(\App\Models\TreeImplementation::class)->thirdStructure(23,1,true));
            (app(\App\Models\TreeImplementation::class)->thirdStructure(24,1,true));
        } catch (Exception $exception) {
            var_dump($exception->getFile() . ' / ' . $exception->getLine() . ' / ' . $exception->getMessage());
        }

    }
}
