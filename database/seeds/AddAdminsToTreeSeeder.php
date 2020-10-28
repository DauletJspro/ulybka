<?php

use Illuminate\Database\Seeder;

class AddAdminsToTreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $structure_ids = [1, 2, 3, 4, 5, 6, 7];
        foreach ($structure_ids as $id) {
            $this->add_admins_to_structure($id);
        }

    }

    public function add_admins_to_structure($structure_id)
    {
        $admin_ids = [3, 4, 5, 6, 1000, 1001, 1002];
        $structure = \App\Models\BinaryStructure::where(['id' => $structure_id])->first();
        $tree = json_decode($structure->tree_representation);
        if (!$tree) {
            $tree = [];
        }
        foreach ($admin_ids as $id) {
            array_push($tree, $id);
        }

        $structure->tree_representation = json_encode($tree);
        $structure->save();

    }
}
