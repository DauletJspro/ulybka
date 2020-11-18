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
            app(BinaryStructureController::class)->to_next_structure(2, 2);
            app(BinaryStructureController::class)->to_next_structure(3, 2);
            app(BinaryStructureController::class)->to_next_structure(4, 4);
            app(BinaryStructureController::class)->to_next_structure(5, 4);
            app(BinaryStructureController::class)->to_next_structure(6, 4);
            app(BinaryStructureController::class)->to_next_structure(7, 4);
            app(BinaryStructureController::class)->to_next_structure(8, 4);
            app(BinaryStructureController::class)->to_next_structure(9, 4);
            app(BinaryStructureController::class)->to_next_structure(10, 4);
            app(BinaryStructureController::class)->to_next_structure(11, 4);
            app(BinaryStructureController::class)->to_next_structure(12, 4);
            app(BinaryStructureController::class)->to_next_structure(13, 2);
            app(BinaryStructureController::class)->to_next_structure(14, 2);
            app(BinaryStructureController::class)->to_next_structure(15, 2);
            app(BinaryStructureController::class)->to_next_structure(16, 2);
            app(BinaryStructureController::class)->to_next_structure(17, 2);
            app(BinaryStructureController::class)->to_next_structure(18, 2);
            app(BinaryStructureController::class)->to_next_structure(19, 2);
            app(BinaryStructureController::class)->to_next_structure(20, 2);

//            app(BinaryStructureController::class)->to_next_structure(22, 4);
//            app(BinaryStructureController::class)->to_next_structure(23, 4);

//            app(BinaryStructureController::class)->to_next_structure(46, 4);
//            app(BinaryStructureController::class)->to_next_structure(47, 4);
//            app(BinaryStructureController::class)->to_next_structure(50, 4);
//            app(BinaryStructureController::class)->to_next_structure(51, 4);
//            app(BinaryStructureController::class)->to_next_structure(52, 4);
//            app(BinaryStructureController::class)->to_next_structure(53, 4);
//            app(BinaryStructureController::class)->to_next_structure(9, 1);
//            app(BinaryStructureController::class)->to_next_structure(10, 1);
//            app(BinaryStructureController::class)->to_next_structure(4, 4);
//            app(BinaryStructureController::class)->to_next_structure(5, 4);
//            app(BinaryStructureController::class)->to_next_structure(12, 4);
//            app(BinaryStructureController::class)->to_next_structure(13, 4);
//            app(BinaryStructureController::class)->to_next_structure(14, 4);
//            app(BinaryStructureController::class)->to_next_structure(4, 4);
//            app(BinaryStructureController::class)->to_next_structure(5, 4);
//            app(BinaryStructureController::class)->to_next_structure(6, 4);
//            app(BinaryStructureController::class)->to_next_structure(7, 4);
//            app(BinaryStructureController::class)->to_next_structure(8, 4);
//            app(BinaryStructureController::class)->to_next_structure(9, 4);
//            app(BinaryStructureController::class)->get_all_parents(15);\

//            $users_till_50 = \App\Models\Users::where('user_id', '>', 3)
//                ->where('user_id', '<',10)->get();
//
//            foreach ($users_till_50 as $item) {
//                app(BinaryStructureController::class)->to_next_structure($item->user_id, 2);
//            }
//            $structure = \App\Models\BinaryStructure::where(['id' => 3])->first();
//            $from_structure = \App\Models\BinaryStructure::where(['id' => 2])->first();
//            app(BinaryStructureController::class)->to_next_structure(4, 3, $structure, $from_structure, null, 2, null);
//            app(BinaryStructureController::class)->to_next_structure(5, 3, $structure, $from_structure, null, 2, null);
//            app(BinaryStructureController::class)->to_next_structure(6, 3, $structure, $from_structure, null, 2, null);
//            app(BinaryStructureController::class)->to_next_structure(7, 3, $structure, $from_structure, null, 2, null);
//            app(BinaryStructureController::class)->to_next_structure(8, 3, $structure, $from_structure, null, 2, null);
//            app(BinaryStructureController::class)->to_next_structure(9, 3, $structure, $from_structure, null, 2, null);
//            app(BinaryStructureController::class)->to_next_structure(10, 3, $structure, $from_structure, null, 2, null);
//            app(BinaryStructureController::class)->to_next_structure(11, 3, $structure, $from_structure, null, 2, null);
//            app(BinaryStructureController::class)->to_next_structure(12, 3, $structure, $from_structure, null, 2, null);
//            app(BinaryStructureController::class)->to_next_structure(13, 3, $structure, $from_structure, null, 2, null);
//            app(BinaryStructureController::class)->to_next_structure(14, 3, $structure, $from_structure, null, 2, null);
//            app(BinaryStructureController::class)->to_next_structure(15, 3, $structure, $from_structure, null, 2, null);
//            app(BinaryStructureController::class)->to_next_structure(16, 3, $structure, $from_structure, null, 2, null);

//            $body_structure = \App\Models\StructureBody::where(['binary_structure_id' => 1])
//                ->where(['number' => 2])->first();
//            app(BinaryStructureController::class)->correct_parents([], [], true, $body_structure);
        } catch (Exception $exception) {
            var_dump($exception->getFile() . ' ' . $exception->getLine() . ' ' . $exception->getMessage());
        }
    }
}
