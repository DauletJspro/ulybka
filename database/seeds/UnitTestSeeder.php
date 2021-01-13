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

        $structure = \App\Models\StructureBody::where(['binary_structure_id' => \App\Models\BinaryStructure::FIRST_STRUCTURE])
            ->where(['number' => 1])->first();
        $tree = json_decode($structure->tree_representation);
        $position1 = array_search(1329, $tree);
        $position2 = array_search(1330, $tree);
        $tree[$position1] = 0;
        $tree[$position2] = 0;
        $structure->tree_representation = json_encode($tree);
        $structure->save();
//        try {
//            (app(\App\Models\TreeImplementation::class)->firstStructure(11,1,false));
//            (app(\App\Models\TreeImplementation::class)->firstStructure(10,1,false));
//            (app(\App\Models\TreeImplementaktion::class)->firstStructure(12,1,false));
//            (app(\App\Models\TreeImplementation::class)->firstStructure(16,1,false));
//            (app(\App\Models\TreeImplementation::class)->firstStructure(14,1,false));
//            (app(\App\Models\TreeImplementation::class)->firstStructure(15,1,false));
//            (app(\App\Models\TreeImplementation::class)->firstStructure(17,1,false));
//            (app(\App\Models\TreeImplementation::class)->firstStructure(18,1,false));
//            (app(\App\Models\TreeImplementation::class)->firstStructure(19,1,false));
//            (app(\App\Models\TreeImplementation::class)->firstStructure(20,1,false));
//            (app(\App\Models\TreeImplementation::class)->firstStructure(21,1,false));
//            (app(\App\Models\TreeImplementation::class)->firstStructure(22,1,false));
//            (app(\App\Models\TreeImplementation::class)->firstStructure(23,1,false));
//            (app(\App\Models\TreeImplementation::class)->firstStructure(24,1,false));
//        } catch (Exception $exception) {
//            var_dump($exception->getFile() . ' / ' . $exception->getLine() . ' / ' . $exception->getMessage());
//        }

    }
}
