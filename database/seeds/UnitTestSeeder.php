<?php

use App\Models\VipStructureBody;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\Redis;

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
            $binaryStructureBody = \App\Models\StructureBody::where('binary_structure_id', 1)
                ->where('number', 1)
                ->first();

            $tree = json_decode($binaryStructureBody->tree_representation);

            var_dump(array_search(221, $tree));
//            app(\App\Models\TreeImplementation::class)->firstStructure(30, 1);
//            app(\App\Models\TreeImplementation::class)->firstStructure(31, 1);
//            app(\App\Models\TreeImplementation::class)->firstStructure(32, 1);
        } catch (Exception $exception) {
            var_dump($exception->getFile() . ' / ' . $exception->getLine() . ' / ' . $exception->getMessage());
        }

    }
}
