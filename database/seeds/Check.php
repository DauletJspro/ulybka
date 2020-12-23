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
            $body_structure = \App\Models\StructureBody::where(['id' => 3])->first();
            $tree = $body_structure->tree_representation;
            $tree = json_decode($tree);
            $idx = array_search(71, $tree);
            $left_child_idx = app(BinaryStructureController::class)->get_left_child_idx($idx);
            $tree[$left_child_idx] = 109;

            $idx = array_search(71, $tree);
            $left_child_idx = app(BinaryStructureController::class)->get_right_child_idx($idx);
            $tree[$left_child_idx] = 106;

            $body_structure->tree_representation = json_encode($tree);
            $body_structure->save();


        } catch (Exception $exception) {
            var_dump($exception->getFile() . ' ' . $exception->getLine() . ' ' . $exception->getMessage());
        }
    }
}
