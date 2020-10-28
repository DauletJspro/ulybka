<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPrimeSumWhenClosedToBinaryStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('binary_structures', function (Blueprint $table) {
            $table->integer('prime_when_closed_structure')->after('to_second_parent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('binary_structures', function (Blueprint $table) {
            $table->dropColumn('prime_when_closed_structure');
        });
    }
}
