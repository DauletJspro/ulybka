<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BinaryStructure;
use App\Models\Currency;
use App\Models\Packet;
use App\Models\UserOperation;
use App\Models\Users;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BinaryStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $structure_id = $request->get('structure_id');
        if (!isset($structure_id)) {
            $structure_id = 1;
        }

        $user_id = $request->get('user_id');
        if (!isset($user_id)) {
            $user_id = Auth::user()->user_id;
        }
        $tree = $this->get_structure_by_user_id($user_id, $structure_id);
        return view('admin.binary_structure.show', ['tree' => $tree, 'user_id' => $user_id, 'structure_id' => $structure_id]);
    }

    public function find_by_id(Request $request)
    {


        $login = $request->login;

        $structure_id = $request->get('structure_id');

        if ($structure_id == "" || !isset($structure_id)) {
            $structure_id = 1;
        }

        $user = Users::where('login', $login)
            ->orWhere('login', 'like', '%' . $login . '%')->first();
        $user_id = $user->user_id;


        return view('admin.binary_structure.show', ['structure_id' => $structure_id, 'user_id' => $user_id]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_structure_by_user_id($id, $structure_id = null)
    {

        if (!isset($structure_id) || $structure_id == "") {
            $structure_id = 1;
        }

        $structure = BinaryStructure::where(['id' => $structure_id])->first();
        $tree = json_decode($structure->tree_representation);

        $index = array_search($id, array_values($tree));
        $tree = array_slice($tree, $index, $index + 8);

        if (!in_array($id, $tree)) {
            $tree = [];
        }
        return $tree;

    }

    public function to_next_structure($user_id, $packet_id = null, $structure = null, $user_packet_id = null)
    {
        if (isset($structure)) {
            $structure_id = $structure->id;
        }
        if (!isset($structure)) {
            $structure_id = BinaryStructure::get_structure_by_packet_id($packet_id);
            $structure = BinaryStructure::where(['id' => $structure_id])->first();
        }
        $tree = json_decode($structure->tree_representation);
        if ($tree == NULL) {
            $this->set_root($user_id, $structure);
            return true;
        }

        $tree = $this->set_child($structure, $user_id);

        $user_idx = array_search($user_id, array_values($tree));

        $first_parent_index = $this->get_first_parent_idx($user_idx, $user_idx, $packet_id, 0, $structure);

        if ($first_parent_index !== NULL) {
            $check_parent = $this->check_parents_has_enough_to_next_tree($first_parent_index, $structure);
            if ($check_parent) {
                $structure = BinaryStructure::where(['id' => ($structure_id + 1)])->first();
                if (in_array($packet_id, [Packet::RUBIN, Packet::SAPPHIRE, Packet::EMERALD, Packet::DIAMOND])) {
                    $this->send_premium($user_id, $packet_id);
                    $this->check_from_check($user_id, $packet_id);
                }
                app(ClassicalStructureController::class)->implement_bonuses($user_packet_id, $packet_id + 1, $tree[$first_parent_index]);
                $this->qualificationUp($tree[$first_parent_index], ($packet_id + 1));
                $this->to_next_structure($tree[$first_parent_index], ($packet_id + 1), $structure, $user_packet_id);
            } else {
                return true;
            }
        } else {
            return true;
        }
    }


    public function send_premium($user_id, $packet_id)
    {
        $binary_structure_id = BinaryStructure::get_structure_by_packet_id($packet_id);
        $binary_structure = BinaryStructure::where(['id' => $binary_structure_id])->first();
        $user = Users::where(['user_id' => $user_id])->first();
        $user->user_money = $user->user_money + $binary_structure->prime_when_closed_structure;
        $user->save();
    }

    public function check_from_check($user_id, $packet_id)
    {
        $binary_structure_id = BinaryStructure::get_structure_by_packet_id($packet_id);
        $binary_structure = BinaryStructure::where(['id' => $binary_structure_id])->first();

        $bonus = $binary_structure->prime_when_closed_structure * ($binary_structure->check_from_check_percentage / 100);
        $two_parents = $this->get_two_parents($user_id);

        if (!empty($two_parents)) {
            foreach ($two_parents as $parent_id) {
                $parent = Users::where(['user_id' => $parent_id])->first();
                $parent->user_money = $parent->user_money + $bonus;
                $parent->save();
            }
        }
    }


    public function get_two_parents($user_id)
    {
        $array = [];
        $counter = 1;
        $user = Users::where(['user_id' => $user_id])->first();
        $parent = Users::where(['user_id' => $user->recommend_user_id])
            ->where(['is_activated' => true])
            ->first();
        while (isset($parent) && $counter < 3) {
            array_push($array, $parent->user_id);
            $parent = Users::where(['user_id' => $parent->recommend_user_id])
                ->where(['is_activated' => true])
                ->first();
            $counter++;
        }

        return $array;
    }

    public function set_child($structure, $user_id, $next_parent_counter = 0)
    {
        $tree = json_decode($structure->tree_representation);
        $parents = $this->get_all_parents($user_id);
        $parents = $this->correct_parents($tree, $parents);


        if (count($parents) && !in_array($user_id, $tree)) {
            $exist = in_array($parents[$next_parent_counter], $tree);
            if (!$exist) {
                $this->set_child($structure, $user_id, $next_parent_counter + 1);
            } else {
                // return parent_id and it's free position
                $check = $this->check_free_position($parents[$next_parent_counter], $structure, $parents);
                if (!$check) {
                    $user_child = $this->all_child_from_user_by_parent_id($parents[$next_parent_counter]);
                    $user_child = $this->correct_child($tree, $user_child);
                    foreach ($user_child as $id) {
                        if (in_array($id, $tree)) {
                            $result = $this->check_free_position($id, $structure);
                            if ($result && !in_array($user_id, $tree)) {
                                $tree = $this->add_child($result['to_place_idx'], $tree, $user_id);
                                $structure->tree_representation = json_encode($tree);
                                $structure->save();
                                return $tree;
                            }
                        }
                    }
                } else {
                    if (!in_array($user_id, $tree)) {
                        $tree = $this->add_child($check['to_place_idx'], $tree, $user_id);
                        $structure->tree_representation = json_encode($tree);
                        $structure->save();
                        return $tree;
                    }
                }
            }
        }
    }

    public function correct_child($tree, $child)
    {
        $array = [];
        foreach ($tree as $child_id) {
            if (in_array($child_id, $child)) {
                array_push($array, $child_id);
            }
        }
        return $array;
    }

    public function correct_parents($tree, $parents)
    {
        $array = [];
        $tree = array_reverse($tree);
        foreach ($tree as $child_id) {
            if (in_array($child_id, $parents)) {
                array_push($array, $child_id);
            }
        }
        return $array;
    }


    public function add_child($to_place_idx, $tree, $user_id)
    {
        $last_count = count($tree);
        for ($i = $last_count; $i <= $to_place_idx; $i++) {
            $tree[$i] = 0;
        }
        $tree[$to_place_idx] = $user_id;
        return $tree;
    }

    public function all_child_from_user_by_parent_id($parent_ids, $count = null)
    {
        $array = [];
        if (!is_array($parent_ids)) {
            $parent_ids = [$parent_ids];
        }
        $users = DB::table('users')->whereIn('recommend_user_id', $parent_ids)->orWhereIn('user_id', $parent_ids)->get();
        foreach ($users as $user) {
            array_push($array, $user->user_id);
        }
        if ($count == count($users)) {
            return $array;
        }

        $count = count($users);
        $result = $this->all_child_from_user_by_parent_id($array, $count);
        return $result;
    }

    public function check_free_position($parent_id, $structure, $parents = null, $counter = 0)
    {
        $tree = json_decode($structure->tree_representation);
        $parent_idx = $this->get_idx_by_user_id($parent_id, $structure);
        $left_child_idx = $this->get_left_child_idx($parent_idx);
        $right_child_idx = $this->get_right_child_idx($parent_idx);

        $left_child_id = isset($tree[$left_child_idx]) ? $tree[$left_child_idx] : null;
        $right_child_id = isset($tree[$right_child_idx]) ? $tree[$right_child_idx] : null;


        if (($left_child_id) && ($right_child_id)) {
            return false;
        }

        if (!($left_child_id)) {
            return ['to_place_idx' => $left_child_idx];
        }

        if (!($right_child_id)) {
            return ['to_place_idx' => $right_child_idx];
        }
    }

    public function get_all_parents($user_id)
    {
        $recommend_user = DB::table('users')->where(['user_id' => $user_id])->first();
        $recommend_user_id = isset($recommend_user) ? $recommend_user->recommend_user_id : null;
        $parents_ids = [];
        while ($recommend_user_id != null && $recommend_user_id != 1) {
            array_push($parents_ids, $recommend_user_id);
            $recommend_user = DB::table('users')->where(['user_id' => $recommend_user_id])->first();
            $recommend_user_id = isset($recommend_user) ? $recommend_user->recommend_user_id : null;
        }
        return $parents_ids;
    }

    public function qualificationUp($user_id, $packet_id)
    {
        $user = Users::get_user($user_id);
        $packet = Packet::where(['packet_id' => $packet_id])->first();
        app(PacketController::class)->qualificationUp($packet, $user);
    }

    public function set_root($user_id, $structure)
    {
        $tree = json_decode($structure->tree_representation);
        if ($tree == NULL) {
            $tree = [];
        }
        $tree[0] = $user_id;
        $tree = json_encode($tree);
        $structure->tree_representation = $tree;
        $structure->save();
    }

    public function get_first_parent_idx($const_child_idx, $child_idx, $packet_id, $counter = 0, $structure = null)
    {
        //check is it left child;
        $parent_index = null;
        if ((($child_idx - 1) % 2) == 0) {
            $parent_index = ($child_idx - 1) / 2;
        } else {
            $parent_index = ($child_idx - 2) / 2;
        }
        $counter++;

        if ($parent_index >= 0) {
            $this->give_bonus_to_parent($const_child_idx, $parent_index, $packet_id, $counter, $structure);
        }
        if ($parent_index < 0) {
            return null;
        } else if ($counter == 2) {
            return $parent_index;
        }

        $result = $this->get_first_parent_idx($const_child_idx, $parent_index, $packet_id, $counter, $structure);
        return $result;
    }


    public function give_bonus_to_parent($child_idx, $parent_index, $packet_id, $counter, $structure)
    {
        $bonus = 0;
        $packet = (Packet::where(['packet_id' => $packet_id])->first());
        $tree = json_decode($structure->tree_representation);
        $binary_percentage = $structure->to_binary_structure;
        $parent_id = $tree[$parent_index];
        $child_id = $tree[$child_idx];
        if ($counter == 1) {
            $bonus = $structure->to_second_parent;
        } elseif ($counter == 2) {
            $bonus = $structure->to_first_parent;
        }


        $packet_price = round(($packet->packet_price * ($packet->to_binary_structure / 100)), 0);
        $bonus = ($bonus / 100) * $packet_price;

        $bonus = round($bonus, 0);


        $parent_user = Users::where('user_id', '=', $parent_id)->first();
        $parent_user = !isset($parent_user) ?
            DB::table('users')->where(['user_id' => $parent_id])->first() :
            Users::find($parent_id);


        try {
            DB::beginTransaction();


            DB::table('users')->where(['user_id' => (int)$parent_id])->update([
                'user_money' => $parent_user->user_money + $bonus,
            ]);

            $operation = new UserOperation();
            $operation->author_id = $child_id;
            $operation->recipient_id = $parent_id;
            $operation->money = $bonus;
            $operation->operation_id = 1;
            $operation->operation_type_id = 17;
            $operation->operation_comment = sprintf('Стол: %s. Бинарный доход %s$ (%s) тг', $packet->packet_name_ru, $bonus, $bonus * Currency::usdToKzt());
            $operation->save();

            DB::commit();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            var_dump($parent_id);
            DB::rollback();
        }
    }

    public function check_parents_has_enough_to_next_tree($parent_index = 0, $structure = 0, $counter = 0, $right_child_idx = null)
    {
        $tree = json_decode($structure->tree_representation);

        $left_child_idx = $this->get_left_child_idx($parent_index);
        if (!($right_child_idx)) {
            $right_child_idx = $this->get_right_child_idx($parent_index);
        }

        if (!(isset($tree[$left_child_idx]) && $tree[$left_child_idx]) ||
            !(isset($tree[$right_child_idx]) && $tree[$right_child_idx])) {
            return false;
        }
        $counter++;
        if ($counter == 1) {
            $this->check_parents_has_enough_to_next_tree($left_child_idx, $structure, $counter, $right_child_idx);
        } else if ($counter == 2) {
            return true;
        }
        return $this->check_parents_has_enough_to_next_tree($right_child_idx, $structure, $counter);

    }

    public function get_idx_by_user_id($user_id, $structure)
    {
        $tree = json_decode($structure->tree_representation);
        $user_idx = array_search($user_id, array_values($tree));
        return $user_idx;
    }

    public function get_left_child_idx($parent_idx)
    {
        $left_child_idx = ($parent_idx * 2) + 1;
        return $left_child_idx;

    }

    public function get_right_child_idx($parent_idx)
    {
        $right_child_idx = ($parent_idx * 2) + 2;
        return $right_child_idx;
    }
}
