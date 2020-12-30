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
            (app(\App\Models\TreeImplementation::class)->secondStructure(11));
            (app(\App\Models\TreeImplementation::class)->secondStructure(10));
            (app(\App\Models\TreeImplementation::class)->secondStructure(12));
            (app(\App\Models\TreeImplementation::class)->secondStructure(16));
            (app(\App\Models\TreeImplementation::class)->secondStructure(14));
            (app(\App\Models\TreeImplementation::class)->secondStructure(15));
            (app(\App\Models\TreeImplementation::class)->secondStructure(17));
            (app(\App\Models\TreeImplementation::class)->secondStructure(18));
            (app(\App\Models\TreeImplementation::class)->secondStructure(19));
            (app(\App\Models\TreeImplementation::class)->secondStructure(20));
            (app(\App\Models\TreeImplementation::class)->secondStructure(21));
            (app(\App\Models\TreeImplementation::class)->secondStructure(22));
            (app(\App\Models\TreeImplementation::class)->secondStructure(23));
            (app(\App\Models\TreeImplementation::class)->secondStructure(24));
        } catch (Exception $exception) {
            var_dump($exception->getFile() . ' / ' . $exception->getLine() . ' / ' . $exception->getMessage());
        }

    }
}
