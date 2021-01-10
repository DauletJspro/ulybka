<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function getIdByPosition($position, $structureBody)
    {
        $tree = json_decode($structureBody->tree_representation);
        return $tree[$position];
    }

    public function getStructureBodyTreeRepresentation($structureBody)
    {
        $tree = json_decode($structureBody->tree_representation);
        return $tree;
    }

    public static function getPosition($structureBody, $user_id)
    {
        $tree = json_decode($structureBody->tree_representation);
        $parentsId = Users::parentsByUserId($user_id);

        foreach ($parentsId as $parentId) {
            if (in_array($parentId, $tree)) {
                $childInTreeByParentId = (new StructureBody)->getChildInTree($tree, [array_search($parentId, $tree)]);


                foreach ($childInTreeByParentId as $childId) {
                    $position = (new StructureBody)->checkFreePosition($childId, $structureBody);
                    if ($position) {
                        return $position;
                    }
                }
                return false;

            }
        }
    }

    public
    function checkFreePosition($userId, $structureBody)
    {
        $tree = $this->getStructureBodyTreeRepresentation($structureBody);
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

    public static function parentHasEnoughChild($parentPosition, $structureBody)
    {
        $tree = (new StructureBody)->getStructureBodyTreeRepresentation($structureBody);

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

    public static function getTreePositionByUserId($userId, $structureBody)
    {
        $tree = json_decode($structureBody->tree_representation);
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
        $structureBody->tree_representation = json_encode($tree);
        $structureBody->number = $number;
        $structureBody->save();

        return $structureBody;
    }

    public function getTreeParentId($childPosition, $binaryStructureBody, $counter = 0)
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
            $this->sendRewardToParent($childPosition, $parentPosition, $packetId, $counter, $binaryStructureBody);
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

        $result = $this->getTreeParentId($parentPosition, $binaryStructureBody, $counter);
        return $result;
    }


    public function getChildInTree($tree, $parentsPosition = [], $array = [])
    {
        $bool = true;
        foreach ($parentsPosition as $parentPosition) {
            $left_child_idx = $this->get_left_child_idx($parentPosition);
            $right_child_idx = $this->get_right_child_idx($parentPosition);
            if (isset($tree[$parentPosition]) && !in_array($tree[$parentPosition], $array)
                && $tree[$parentPosition] != 0) {
                $array[$parentPosition] = $tree[$parentPosition];
                $bool = false;
            }
            if (isset($tree[$left_child_idx]) && !in_array($tree[$left_child_idx], $array)
                && $tree[$left_child_idx] != 0) {
                $array[$left_child_idx] = $tree[$left_child_idx];
                $bool = false;
            }
            if (isset($tree[$right_child_idx]) && !in_array($tree[$right_child_idx], $array)
                && $tree[$right_child_idx] != 0) {
                $array[$right_child_idx] = $tree[$right_child_idx];
                $bool = false;
            }
        }
        $parentsPosition = [];
        foreach ($array as $user_id) {
            array_push($parentsPosition, array_search($user_id, array_filter($tree)));
        }
        #TODO sort correctly
        sort($parentsPosition);
        if ($bool) {
            return ($array);
        } else {
            $this->getChildInTree($tree, $parentsPosition, $array);
        }
        return $this->getChildInTree($tree, $parentsPosition, $array);
    }

    function sendRewardToParent($childPosition, $parentPosition, $packetId, $counter, $structureBody)
    {
        $bonus = 0;
        $packet = (Packet::where(['packet_id' => $packetId])->first());
        $tree = json_decode($structureBody->tree_representation);
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
