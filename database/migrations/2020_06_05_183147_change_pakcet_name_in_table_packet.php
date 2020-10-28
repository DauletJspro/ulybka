<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePakcetNameInTablePacket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('user_status')
            ->where(['user_status_id' => \App\Models\UserStatus::STOL_6])
            ->update(['user_status_name' => 'Серебряный Менеджер']);

        DB::table('user_status')
            ->where(['user_status_id' => \App\Models\UserStatus::GOLD_DIRECTOR])
            ->update(['user_status_name' => 'Золотой Директор']);        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
