<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class UserStatus extends Model
{
    protected $table = 'user_status';
    protected $primaryKey = 'user_status_id';

    const SILVER = 1;
    const GOLD = 2;
    const PLATINUM = 3;
    const RUBIN = 4;
    const SAPPHIRE = 5;
    const EMERALD = 6;
    const DIAMOND = 7;

    use SoftDeletes;
    protected $dates = ['deleted_at'];


    public static function getStatusName($id)
    {
        $statusName = UserStatus::where(['user_status_id' => $id])->first();
        $statusName = $statusName ? $statusName->user_status_name : NULL;
        return $statusName;
    }
}
