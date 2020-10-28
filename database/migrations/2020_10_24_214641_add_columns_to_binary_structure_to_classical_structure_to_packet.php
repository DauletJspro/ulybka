<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToBinaryStructureToClassicalStructureToPacket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packet', function (Blueprint $table) {
            $table->double('to_binary_structure')->after('packet_price');
            $table->double('to_classical_structure')->after('to_binary_structure');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packet', function (Blueprint $table) {
            $table->dropColumn('to_binary_structure');
            $table->dropColumn('to_classical_structure');
        });
    }
}
