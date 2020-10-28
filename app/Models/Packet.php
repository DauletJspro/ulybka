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

    const SILVER = 1;
    const GOLD = 2;
    const PLATINUM = 3;
    const RUBIN = 4;
    const SAPPHIRE = 5;
    const EMERALD = 6;
    const DIAMOND = 7;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function actualPacket()
    {
        return [
            self::SILVER,
            self::GOLD,
            self::PLATINUM,
            self::RUBIN,
            self::SAPPHIRE,
            self::EMERALD,
            self::DIAMOND,
        ];
    }

    public function userPacket()
    {
        $this->hasMany('App\Models\UserPacket');
    }
}
