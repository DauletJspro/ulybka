<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddAdvisorBonusToOperationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('operation_type')->insert([
            'operation_type_id' => 40,
            'operation_type_name_ru' => 'Кураторский бонус',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
