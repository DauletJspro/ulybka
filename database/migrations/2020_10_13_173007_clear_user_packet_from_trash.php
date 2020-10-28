<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClearUserPacketFromTrash extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user_packets = \App\Models\UserPacket::whereNotIn('packet_id', [1, 2, 3, 4, 5, 6, 7])
            ->get()->pluck('user_packet_id')->toArray();

        \App\Models\UserPacket::destroy($user_packets);

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
