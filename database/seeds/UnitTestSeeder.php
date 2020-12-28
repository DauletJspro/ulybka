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
            (app(\App\Models\TreeImplementation::class)->fourthStructure(11));
            (app(\App\Models\TreeImplementation::class)->fourthStructure(10));
            (app(\App\Models\TreeImplementation::class)->fourthStructure(12));
            (app(\App\Models\TreeImplementation::class)->fourthStructure(16));
            (app(\App\Models\TreeImplementation::class)->fourthStructure(14));
            (app(\App\Models\TreeImplementation::class)->fourthStructure(15));
            (app(\App\Models\TreeImplementation::class)->fourthStructure(17));
            (app(\App\Models\TreeImplementation::class)->fourthStructure(18));
            (app(\App\Models\TreeImplementation::class)->fourthStructure(19));
            (app(\App\Models\TreeImplementation::class)->fourthStructure(20));
            (app(\App\Models\TreeImplementation::class)->fourthStructure(21));
            (app(\App\Models\TreeImplementation::class)->fourthStructure(22));
            (app(\App\Models\TreeImplementation::class)->fourthStructure(23));
            (app(\App\Models\TreeImplementation::class)->fourthStructure(24));
        } catch (Exception $exception) {
            var_dump($exception->getFile() . ' / ' . $exception->getLine() . ' / ' . $exception->getMessage());
        }

    }
}
