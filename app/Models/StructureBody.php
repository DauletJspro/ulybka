<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class StructureBody extends Model
{
    protected $table = 'structure_body';
    protected $fillable = ['binary_structure_id', 'number', 'tree_representation'];


    public function structure()
    {
        return $this->belongsTo(BinaryStructure::class, 'binary_structure_id', 'id');
    }

    public function getStructureBody($binaryStructureId, $number)
    {
        $binaryStructureBody = StructureBody::where('binary_structure_id', $binaryStructureId)
            ->where('number', $number)
            ->first();

        return $binaryStructureBody;
    }

    public static function getIdByPosition($position, $tree)
    {
        return $tree[$position];
    }


    public static function getPosition($user_id, $tree)
    {
        $parentsId = Users::parentsByUserId($user_id);

        foreach ($parentsId as $parentId) {
            if (in_array($parentId, $tree)) {
                $position = (new StructureBody)->getChildInTree($tree, [array_search($parentId, $tree)]);
                return $position;
            }
        }
        return false;
    }

    public
    function checkFreePosition($userId, $tree)
    {
        $parentPosition = $position = array_search($userId, $tree);
        $leftChildPosition = $this->get_left_child_idx($parentPosition);
        $rightChildPosition = $this->get_right_child_idx($parentPosition);

        $leftChildId = isset($tree[$leftChildPosition]) ? $tree[$leftChildPosition] : null;
        $rightChildId = isset($tree[$rightChildPosition]) ? $tree[$rightChildPosition] : null;


        if (($leftChildId) && ($rightChildId)) {
            return false;
        }

        if (!($leftChildId)) {
            return $leftChildPosition;
        }

        if (!($rightChildId)) {
            return $rightChildPosition;
        }
    }

    public static function parentHasEnoughChild($parentPosition, $structureBody, $tree)
    {
        $leftChildPosition = (new StructureBody)->get_left_child_idx($parentPosition);
        $rightChildPosition = (new StructureBody)->get_right_child_idx($parentPosition);

        if (!(isset($tree[$leftChildPosition]) && $tree[$leftChildPosition]) ||
            !(isset($tree[$rightChildPosition]) && $tree[$rightChildPosition])) {
            return false;
        }

        if (in_array($structureBody->binary_structure_id, [
            BinaryStructure::SECOND_STRUCTURE,
            BinaryStructure::FOURTH_STRUCTURE,
            BinaryStructure::SEVENTH_STRUCTURE,
            BinaryStructure::NINTH_STRUCTURE
        ])) {
            return true;
        }

        $left_left_child_idx = (new StructureBody)->get_left_child_idx($leftChildPosition);
        $left_right_child_idx = (new StructureBody)->get_left_child_idx($leftChildPosition);

        if (!(isset($tree[$left_left_child_idx]) && $tree[$left_left_child_idx]) ||
            !(isset($tree[$left_right_child_idx]) && $tree[$left_right_child_idx])) {
            return false;
        }


        $right_left_child_idx = (new StructureBody)->get_left_child_idx($rightChildPosition);
        $right_right_child_idx = (new StructureBody)->get_right_child_idx($rightChildPosition);

        if (!(isset($tree[$right_left_child_idx]) && $tree[$right_left_child_idx]) ||
            !(isset($tree[$right_right_child_idx]) && $tree[$right_right_child_idx])) {
            return false;
        }

        return true;

    }

    public static function getTreePositionByUserId($userId, $structureBody, $tree)
    {
        $position = array_search($userId, $tree);
        if ($structureBody->number > 1 && in_array($userId, $tree) && array_count_values($tree)[$userId] >= 2) {
            $tempTree = $tree;
            $tempTree[$position] = 0;
            $position = array_search($userId, $tempTree);
        }

        return $position;
    }


    public static function setRootUsersToStructureBody($binaryStructureId, $number)
    {

        $tree = [2, 3, 4, 5, 6, 7, 8];

        $structureBody = new StructureBody();
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

    public function getTreeParentId($childPosition, $binaryStructureBody, $tree, $counter = 0)
    {
        $parentPosition = null;
        if ((($childPosition - 1) % 2) == 0) {
            $parentPosition = ($childPosition - 1) / 2;
        } else {
            $parentPosition = ($childPosition - 2) / 2;
        }
        $counter++;

        if ($parentPosition != 0 && $binaryStructureBody->view_type != BinaryStructure::VIEW_TYPE_ONLY_TRIPLE) {
            $packetId = Packet::getPacketIdByBinaryStructure($binaryStructureBody->binary_structure_id);
            $this->sendRewardToParent($childPosition, $parentPosition, $packetId, $counter, $binaryStructureBody, $tree);
        }

        $countLimit = 2;
        if (in_array($binaryStructureBody->binary_structure_id, [
            BinaryStructure::SECOND_STRUCTURE,
            BinaryStructure::FOURTH_STRUCTURE,
            BinaryStructure::SEVENTH_STRUCTURE,
            BinaryStructure::NINTH_STRUCTURE
        ])) {
            $countLimit = 1;
        }

        if ($parentPosition < 0) {
            return null;
        } else if ($counter == $countLimit) {
            return $parentPosition;
        }

        $result = $this->getTreeParentId($parentPosition, $binaryStructureBody, $tree, $counter);
        return $result;
    }


    public function getChildInTree($tree, $parentsPosition = [], $array = [])
    {
        foreach ($parentsPosition as $parentPosition) {
            $left_child_idx = $this->get_left_child_idx($parentPosition);
            $right_child_idx = $this->get_right_child_idx($parentPosition);
            if (isset($tree[$parentPosition]) && !in_array($tree[$parentPosition], $array)
                && $tree[$parentPosition] != 0) {
                $array[$parentPosition] = $tree[$parentPosition];
            }
            if (isset($tree[$left_child_idx]) && !in_array($tree[$left_child_idx], $array)
                && $tree[$left_child_idx] != 0) {
                $array[$left_child_idx] = $tree[$left_child_idx];
            }
            if (isset($tree[$right_child_idx]) && !in_array($tree[$right_child_idx], $array)
                && $tree[$right_child_idx] != 0) {
                $array[$right_child_idx] = $tree[$right_child_idx];
            }
        }

        $parentsPosition = [];
        foreach ($array as $user_id) {
            array_push($parentsPosition, $this->fast_array_search($user_id, $tree));
        }
        #TODO sort correctly
        sort($parentsPosition);

        foreach ($array as $user_id) {
            if ($position = $this->checkFreePosition($user_id, $tree)) {
                return $position;
            }
        }
        $this->getChildInTree($tree, $parentsPosition, $array);

        return $this->getChildInTree($tree, $parentsPosition, $array);
    }

    function fast_array_search($needle, $haystack)
    {
        return array_flip($haystack)[$needle];
    }

    function sendRewardToParent($childPosition, $parentPosition, $packetId, $counter, $structureBody, $tree)
    {
        $bonus = 0;
        $packet = (Packet::where(['packet_id' => $packetId])->first());
        $parentId = $tree[$parentPosition];
        $childId = $tree[$childPosition];

        if ($counter == 1) {
            $bonus = $structureBody->structure->to_second_parent;
        } elseif ($counter == 2) {
            $bonus = $structureBody->structure->to_first_parent;
        }

        $packet_price = $packet->packet_price;
        $bonus = ($bonus / 100) * $packet_price;
        $bonus = round($bonus, 0);

        if ($bonus) {
            try {
                DB::beginTransaction();
                $parentUser = Users::where('user_id', '=', $parentId)->first();
                $parentUser = !isset($parentUser) ?
                    DB::table('users')->where(['user_id' => $parentId])->first() :
                    Users::find($parentId);


                DB::table('users')->where(['user_id' => (int)$parentId])->update([
                    'user_money' => $parentUser->user_money + $bonus,
                ]);

                // send money to payee
                if ($structureBody->binary_structure_id == BinaryStructure::FIRST_STRUCTURE) {
                    $moneyToSendPayee = Users::whereIn('user_id', [2000, 2001, 2002])->get();
                    foreach ($moneyToSendPayee as $user) {
                        $money = $packet_price * (7 / 100);
                        $user->user_money = $user->user_money + $money;
                        if ($user->save()) {
                            Operation::recordSendMoneyToPayee($childId, $user->user_id, $money);
                        }
                    }
                }


                Operation::recordSendReward($childId, $parentId, $bonus, $structureBody);
                DB::commit();
            } catch (\Exception $e) {
                var_dump($e->getMessage());
                var_dump($parentId);
                DB::rollback();
            }
        }

    }


    public
    function get_left_child_idx($parent_idx)
    {
        $left_child_idx = ($parent_idx * 2) + 1;
        return $left_child_idx;

    }

    public
    function get_right_child_idx($parent_idx)
    {
        $right_child_idx = ($parent_idx * 2) + 2;
        return $right_child_idx;
    }

}
