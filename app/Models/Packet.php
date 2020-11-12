<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use DB;

class Packet extends Model
{
    protected $table = 'packet';
    protected $primaryKey = 'packet_id';

    const FIRST_TABLE = 1;
    const SECOND_TABLE = 2;
    const THIRD_TABLE = 3;
    const FOURTH_TABLE = 4;
    const FIFTH_TABLE = 5;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function actualPacket()
    {
        return [
            self::FIRST_TABLE,
            self::SECOND_TABLE,
            self::THIRD_TABLE,
            self::FOURTH_TABLE,
            self::FIFTH_TABLE,
        ];
    }

    public function userPacket()
    {
        $this->hasMany('App\Models\UserPacket');
    }
}
