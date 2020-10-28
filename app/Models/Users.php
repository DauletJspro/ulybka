<?php

namespace App\Models;

use Carbon\Carbon;
use http\Client\Curl\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Users extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $primaryKey = 'user_id';
    protected $fillable = ['email', 'password', 'login', 'user_id'];

    const ADMIN = 1;
    const CLIENT = 2;
    const MODERATOR = 3;

    use SoftDeletes;

    protected $dates = ['deleted_at'];


    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }

    public function getInicioAttribute($val)
    {
        return Carbon::parse($val);
    }

    public function getFinAttribute($val)
    {
        return Carbon::parse($val);
    }

    public static function get_user($id)
    {
        $user = DB::table('users')->where('user_id', '=', $id)->first();
        $user = isset($user) ? self::find($id) : self::where(['user_id' => $id])->first();
        return $user;
    }

    public static function parentFollowers($parent_id)
    {
        return Users::where(['recommend_user_id' => $parent_id])->get();
    }

    public static function isEnoughStatuses($parent_id, $status_id)
    {
        $followerStatusIds = [];
        $followers = Users::where(['recommend_user_id' => $parent_id])->get();

        foreach ($followers as $follower) {
            if ($follower->status_id >= $status_id) {
                array_push($followerStatusIds, $follower->status_id);
            }
        }
        $followerStatusIds = array_filter($followerStatusIds);
        if (count($followerStatusIds) >= 2) {
            return true;
        }
        return false;
    }
}
