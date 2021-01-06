<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Packet extends Model
{
    protected $table = 'packet';
    protected $primaryKey = 'packet_id';

    const FIRST_TABLE = 1;
    const SECOND_TABLE = 2;
    const THIRD_TABLE = 3;
    const FOURTH_TABLE = 4;
    const FIFTH_TABLE = 5;

    const FIRST_TABLE_VIP = 6;
    const SECOND_TABLE_VIP = 7;
    const THIRD_TABLE_VIP = 8;
    const FOURTH_TABLE_VIP = 9;
    const FIFTH_TABLE_VIP = 10;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function actualPacket()
    {
        return [
            self::FIRST_TABLE,
            self::FIRST_TABLE_VIP,
        ];
    }

    public function userPacket()
    {
        $this->hasMany('App\Models\UserPacket');
    }

    public static function getPacketIdByBinaryStructure($binaryStructureId)
    {
        switch ($binaryStructureId) {
            case BinaryStructure::FIRST_STRUCTURE:
                $packetId = Packet::FIRST_TABLE;
                break;
            case BinaryStructure::SECOND_STRUCTURE:
                $packetId = Packet::SECOND_TABLE;
                break;
            case BinaryStructure::THIRD_STRUCTURE:
                $packetId = Packet::THIRD_TABLE;
                break;
            case BinaryStructure::FOURTH_STRUCTURE:
                $packetId = Packet::FOURTH_TABLE;
                break;
            case BinaryStructure::FIFTH_STRUCTURE:
                $packetId = Packet::FIFTH_TABLE;
                break;
            case BinaryStructure::SIXTH_STRUCTURE:
                $packetId = Packet::FIRST_TABLE_VIP;
                break;
            case BinaryStructure::SEVENTH_STRUCTURE:
                $packetId = Packet::SECOND_TABLE_VIP;
                break;
            case BinaryStructure::EIGHTH_STRUCTURE:
                $packetId = Packet::THIRD_TABLE_VIP;
                break;
            case BinaryStructure::NINTH_STRUCTURE:
                $packetId = Packet::FOURTH_TABLE_VIP;
                break;
            case BinaryStructure::TENTH_STRUCTURE:
                $packetId = Packet::FIFTH_TABLE_VIP;
                break;
        }

        return $packetId;
    }
}
