<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Label;

class BinaryStructure extends Model
{
    protected $table = 'binary_structures';

    protected $fillable = ['name', 'type', 'tree_representation'];

    const FIRST_STRUCTURE = 1;
    const SECOND_STRUCTURE = 2;
    const THIRD_STRUCTURE = 3;
    const FOURTH_STRUCTURE = 4;
    const FIFTH_STRUCTURE = 5;
    const SIXTH_STRUCTURE = 6;
    const SEVENTH_STRUCTURE = 7;
    const EIGHTH_STRUCTURE = 8;
    const NINTH_STRUCTURE = 9;
    const TENTH_STRUCTURE = 10;

    const VIEW_TYPE_SIMPLE = 1;
    const VIEW_TYPE_ONLY_TRIPLE = 2;


    public static function get_body_structure_by_number($binary_structure_id, $number = 1)
    {
        $structure_body = StructureBody::where(['binary_structure_id' => $binary_structure_id])
            ->where(['number' => $number])
            ->first();

        return $structure_body;
    }

    public function structure_body()
    {
        return $this->hasMany(StructureBody::class, 'binary_structure_id', 'id');
    }

    public static function get_structure_by_packet_id($id)
    {
        $structure_id = null;
        switch ($id) {
            case Packet::FIRST_TABLE:
                $structure_id = self::FIRST_STRUCTURE;
                break;
            case Packet::SECOND_TABLE:
                $structure_id = self::SECOND_STRUCTURE;
                break;
            case Packet::THIRD_TABLE:
                $structure_id = self::THIRD_STRUCTURE;
                break;
            case Packet::FOURTH_TABLE:
                $structure_id = self::FOURTH_STRUCTURE;
                break;
            case Packet::FIFTH_TABLE:
                $structure_id = self::FIFTH_STRUCTURE;
                break;
        }
        return $structure_id;
    }


    public static function get_binary_tree_by_user($user_id, $structure, $number)
    {
        $array = [];
        $user_array = [];
        $body_structure = StructureBody::where(['binary_structure_id' => $structure->id])
            ->where(['number' => $number])->first();
        $tree = json_decode($body_structure->tree_representation);
        $user_idx = array_search($user_id, array_values($tree));

        $left_child_idx = self::get_left_child_idx($user_idx);
        $right_child_idx = self::get_right_child_idx($user_idx);

        $left_left_child_idx = self::get_left_child_idx($left_child_idx);
        $left_right_child_idx = self::get_right_child_idx($left_child_idx);

        $right_left_child_idx = self::get_left_child_idx($right_child_idx);
        $right_right_child_idx = self::get_right_child_idx($right_child_idx);

        $idxs = [
            $user_idx,
            $left_child_idx,
            $right_child_idx,
            $left_left_child_idx,
            $left_right_child_idx,
            $right_left_child_idx,
            $right_right_child_idx,
        ];


        foreach ($idxs as $idx) {
            if (isset($tree[$idx])) {
                array_push($array, $tree[$idx]);
            }
        }

        foreach ($array as $key => $user_id) {
            $user = Users::get_user($user_id);
            $user_array[$key] = $user;
        }

        return $user_array;
    }


    public static function get_left_child_idx($parent_idx)
    {
        $left_child_idx = ($parent_idx * 2) + 1;
        return $left_child_idx;

    }

    public static function get_right_child_idx($parent_idx)
    {
        $right_child_idx = ($parent_idx * 2) + 2;
        return $right_child_idx;
    }


}
