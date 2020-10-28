<?php

use App\Models\Users;
use App\Models\UserStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePreviusParentStatusIdInTableUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $parents = Users::all();
        foreach ($parents as $parent) {
            $parentFollowers = Users::parentFollowers($parent->user_id);
            $needNumber = 5; // Necessary number of followers for update parent status
            if (count($parentFollowers) >= $needNumber) {
                if ($parent->status_id == UserStatus::MANAGER && Users::isEnoughStatuses($parent->user_id, UserStatus::MANAGER)) {
                    $parent->status_id = UserStatus::STOL_5;
                }
                if ($parent->status_id == UserStatus::STOL_5 && Users::isEnoughStatuses($parent->user_id, UserStatus::STOL_5)) {
                    $parent->status_id = UserStatus::STOL_6;
                }
                if ($parent->status_id == UserStatus::STOL_6 && Users::isEnoughStatuses($parent->user_id, UserStatus::STOL_6)) {
                    $parent->status_id = UserStatus::STOL_7;
                }               
                $parent->save();
            }
        }
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
