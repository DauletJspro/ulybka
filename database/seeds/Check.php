<?php

use App\Http\Controllers\Admin\BinaryStructureController;
use Illuminate\Database\Seeder;

class Check extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
//            (app(\App\Http\Controllers\Admin\ClassicalStructureController::class)
//                ->implement_bonuses(1153));
            app(BinaryStructureController::class)
                ->check_from_check(14, 5);
        } catch (Exception $exception) {
            var_dump($exception->getFile() . ' ' . $exception->getLine() . ' ' . $exception->getMessage());
        }
    }
}
