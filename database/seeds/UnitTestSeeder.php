<?php

use App\Models\BinaryStructure;
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
            $users = \App\Models\Users::where('user_id', '<=', 50)->get();
            foreach ($users as $user) {
                app(\App\Models\TreeImplementation::class)->firstStructure($user->user_id, 1, false);
            }

        } catch (Exception $exception) {
            var_dump($exception->getFile() . ' / ' . $exception->getLine() . ' / ' . $exception->getMessage());
        }

    }
}
