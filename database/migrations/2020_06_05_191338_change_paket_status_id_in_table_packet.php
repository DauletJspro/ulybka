<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePaketStatusIdInTablePacket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('packet')
            ->where(['packet_id' => \App\Models\Packet::PACKET_STOL_3])
            ->update(['packet_status_id' => \App\Models\UserStatus::MANAGER]);
        DB::table('packet')
            ->where(['packet_id' => \App\Models\Packet::PACKET_STOL_4])
            ->update(['packet_status_id' => \App\Models\UserStatus::STOL_6]);
        DB::table('packet')
            ->where(['packet_id' => \App\Models\Packet::PACKET_STOL_4])
            ->update(['packet_status_id' => \App\Models\UserStatus::STOL_6]);
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
