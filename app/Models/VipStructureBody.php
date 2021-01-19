<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class VipStructureBody extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'vip_structure_body';


    public function structure()
    {
        return $this->belongsTo(BinaryStructure::class, 'binary_structure_id', 'id');
    }

    public function getStructureBody($binaryStructureId, $number)
    {
        $binaryStructureBody = VipStructureBody::where('binary_structure_id', $binaryStructureId)
            ->where('number', $number)
            ->first();

        return $binaryStructureBody;
    }

    public static function setRootUsersToStructureBody($binaryStructureId, $number)
    {

        $tree = [2, 3, 4, 5, 6, 7, 8];

        $structureBody = new VipStructureBody();
        $structureBody->binary_structure_id = $binaryStructureId;
        $structureBody->number = $number;
        $structureBody->tree_representation = json_encode($tree);
        $structureBody->save();

        $structureName = BinaryStructure::where(['id' => $binaryStructureId])->first()->type;

        $redis = new Redis();

        $redis_key = $structureName . ':' . $number;
        foreach ($tree as $key => $item) {
            $redis::zAdd(($redis_key), $item, $key);
        }

        $tree = ($redis::zRange($redis_key, 0, -1, 'WITHSCORES'));
        return $tree;

    }

    public function getStructureBodyTreeRepresentation($structureBody)
    {
        $tree = json_decode($structureBody->tree_representation);
        return $tree;
    }

}
