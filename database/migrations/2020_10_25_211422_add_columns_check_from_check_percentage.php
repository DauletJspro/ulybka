<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsCheckFromCheckPercentage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('binary_structures', function (Blueprint $table) {
            $table->double('check_from_check_percentage')->after('prime_when_closed_structure');
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
            $table->dropColumn('check_from_check_percentage');
        });
    }
}
