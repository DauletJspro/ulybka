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

    public static function get_structure_by_packet_id($id)
    {
        $structure_id = null;
        switch ($id) {
            case Packet::SILVER:
                $structure_id = self::FIRST_STRUCTURE;
                break;
            case Packet::GOLD:
                $structure_id = self::SECOND_STRUCTURE;
                break;
            case Packet::PLATINUM:
                $structure_id = self::THIRD_STRUCTURE;
                break;
            case Packet::RUBIN:
                $structure_id = self::FOURTH_STRUCTURE;
                break;
            case Packet::SAPPHIRE:
                $structure_id = self::FIFTH_STRUCTURE;
                break;
            case Packet::EMERALD:
                $structure_id = self::SIXTH_STRUCTURE;
                break;
            case Packet::DIAMOND:
                $structure_id = self::SEVENTH_STRUCTURE;
                break;
        }
        return $structure_id;
    }


    public static function get_binary_tree_by_user($user_id, $structure)
    {
        $array = [];
        $user_array = [];
        $tree = json_decode($structure->tree_representation);
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
