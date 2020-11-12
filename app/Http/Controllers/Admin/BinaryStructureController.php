<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BinaryStructure;
use App\Models\Currency;
use App\Models\Packet;
use App\Models\StructureBody;
use App\Models\UserOperation;
use App\Models\Users;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\VarDumper\Tests\Fixtures\bar;

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
        $number = $request->get('number');
        if (!isset($structure_id)) {
            $structure_id = 1;
        }
        if (!isset($number)) {
            $number = 1;
        }

        $user_id = $request->get('user_id');
        if (!isset($user_id)) {
            $user_id = Auth::user()->user_id;
        }
        $tree = $this->get_structure_by_user_id($user_id, $structure_id, $number);

        return view('admin.binary_structure.show', [
            'tree' => $tree,
            'user_id' => $user_id,
            'structure_id' => $structure_id,
            'number' => $number,
        ]);
    }

    public function find_by_id(Request $request)
    {

        $login = $request->login;
        $number = $request->get('number');
        $structure_id = $request->get('structure_id');

        if ($structure_id == "" || !isset($structure_id)) {
            $structure_id = 1;
        }

        if ($number == "" || !isset($number)) {
            $number = 1;
        }

        $user = Users::where('login', $login)
            ->orWhere('login', 'like', '%' . $login . '%')->first();
        $user_id = $user->user_id;


        return view('admin.binary_structure.show', [
            'structure_id' => $structure_id,
            'user_id' => $user_id,
            'number' => $number,
        ]);


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

    public function get_structure_by_user_id($id, $structure_id = null, $number = 1)
    {

        if (!isset($structure_id) || $structure_id == "") {
            $structure_id = 1;
        }

        $body_structure = StructureBody::where('binary_structure_id', '=', $structure_id)
            ->where('number', '=', $number)->first();

        $tree = json_decode($body_structure->tree_representation);

        $index = array_search($id, array_values($tree));
        $tree = array_slice($tree, $index, $index + 8);

        if (!in_array($id, $tree)) {
            $tree = [];
        }
        return $tree;

    }

    public function to_next_structure($user_id, $packet_id = null, $structure = null, $from_structure = null, $user_packet_id = null, $body_structure_number = 1, $parent_number = null)
    {

        $copy_structure = false;
        if (isset($structure)) {
            $structure_id = $structure->id;
        }

        if (!isset($structure)) {
            $structure_id = BinaryStructure::get_structure_by_packet_id($packet_id);
            $structure = BinaryStructure::where(['id' => $structure_id])->first();
        }


        $body_structure = BinaryStructure::get_body_structure_by_number($structure->id, $body_structure_number);
        $tree = isset($body_structure) ? json_decode($body_structure->tree_representation) : null;

        if ($body_structure_number > 1) {
            $copy_structure = true;
        }


        if ($tree == NULL) {
            $this->set_root($user_id, $structure, $from_structure, $body_structure_number, $parent_number);
            return true;
        }

        if ($copy_structure) {
            $tree = $this->set_child_to_copy_structure($structure, $from_structure, $user_id, 0, $body_structure, $parent_number);
        } else {
            $tree = $this->set_child($structure, $user_id, 0, $body_structure);
        }

        if (isset($parent_number)) {
            $user_id = sprintf("%s_%s", $user_id, $parent_number);
        }


        $user_idx = $tree ? array_search($user_id, array_values($tree)) : null;

        if ($copy_structure) {
            var_dump($parent_number);
        }

        if (!$user_idx) {
            return true;
        }

        $first_parent_index = $this->get_first_parent_idx($user_idx, $user_idx, 0, $structure, $body_structure, $packet_id);

        if ($first_parent_index !== NULL) {
            $check_parent = $this->check_parents_has_enough_to_next_tree($first_parent_index, $body_structure);

            if ($check_parent && $structure->id != BinaryStructure::FIFTH_STRUCTURE) {
                $from_structure = $structure;
                if ($structure->id == BinaryStructure::THIRD_STRUCTURE) {
                    $parent = explode("_", $tree[$first_parent_index]);
                    var_dump($parent);
                    $first_parent_id = $parent[0];
                    $parent_number = isset($parent[1]) ? $parent[1] : 1;
                    $structure = BinaryStructure::where(['id' => BinaryStructure::FIRST_STRUCTURE])->first();
                    $this->duplicate_notification($first_parent_id, $packet_id);
                    $this->to_next_structure($first_parent_id, Packet::FIRST_TABLE, $structure, $from_structure, $user_packet_id, ($body_structure_number + 1), $parent_number);
                }
                if ($structure->id == BinaryStructure::FOURTH_STRUCTURE) {
                    $parent = explode("_", $tree[$first_parent_index]);
                    $first_parent_id = $parent[0];
                    $parent_number = isset($parent[1]) ? $parent[1] : 1;
                    $structure = BinaryStructure::where(['id' => BinaryStructure::FIRST_STRUCTURE])->first();
                    $this->duplicate_notification($first_parent_id, $packet_id);
                    $this->to_next_structure($first_parent_id, Packet::FIRST_TABLE, $structure, $from_structure, $user_packet_id, ($body_structure_number + 1), $parent_number);
                }

                $structure = BinaryStructure::where(['id' => ($structure_id + 1)])->first();
                $first_parent_id = $tree[$first_parent_index];


                if ($copy_structure) {
                    $parent = explode("_", $tree[$first_parent_index]);
                    $first_parent_id = $parent[0];
                    $parent_number = $parent[1];
                    var_dump($parent_number);
                    $this->qualificationUp($first_parent_id, ($packet_id + 1));
                    $this->to_next_structure($first_parent_id, ($packet_id + 1), $structure, $from_structure, $user_packet_id, ($body_structure_number), $parent_number);
                } else {
                    $this->qualificationUp($first_parent_id, ($packet_id + 1));
                    $this->to_next_structure($first_parent_id, ($packet_id + 1), $structure, $from_structure, $user_packet_id);
                }

            } else {
                return true;
            }
        } else {
            return true;
        }
    }


    public
    function duplicate_notification($user_id, $packet_id)
    {
        $operation = new UserOperation();
        $operation->author_id = null;
        $operation->recipient_id = $user_id;
        $operation->money = 0;
        $operation->operation_id = 1;
        $operation->operation_type_id = 10;
        $operation->operation_comment = sprintf('Реинвестирование, покупка первого стола на сумму 10000тг на закрытие %s - го стола.', $packet_id);
        $operation->save();
    }


    public
    function send_premium($user_id, $packet_id)
    {
        $binary_structure_id = BinaryStructure::get_structure_by_packet_id($packet_id);
        $binary_structure = BinaryStructure::where(['id' => $binary_structure_id])->first();
        $user = Users::where(['user_id' => $user_id])->first();
        $user->user_money = $user->user_money + $binary_structure->prime_when_closed_structure;
        $user->save();
    }

    public
    function check_from_check($user_id, $packet_id)
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


    public
    function get_two_parents($user_id)
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

    public
    function set_child($structure, $user_id, $next_parent_counter = 0, $body_structure)
    {
        $tree = json_decode($body_structure->tree_representation);
        $parents = $this->get_all_parents($user_id);
        $parents = $this->correct_parents($tree, $parents);

        if (count($parents) && !in_array($user_id, $tree)) {
            $exist = in_array($parents[$next_parent_counter], $tree);
            if (!$exist) {
                $this->set_child($structure, $user_id, $next_parent_counter + 1, $body_structure);
            } else {
                $check = $this->check_free_position($parents[$next_parent_counter], $tree);

                if (!$check) {
                    $user_child = $this->all_child_from_user_by_parent_id($parents[$next_parent_counter], null);
                    $user_child = $this->correct_child($tree, $user_child, $body_structure);
                    $tree = $this->set_by_user_child($user_child, $tree, $user_id, $body_structure);
                    return $tree;
                } else {
                    if (!in_array($user_id, $tree)) {
                        $tree = $this->add_child($check['to_place_idx'], $tree, $user_id);
                        $body_structure->tree_representation = json_encode($tree);
                        $body_structure->save();
                        return $tree;
                    }
                }
            }
        }
        return [];
    }

    public
    function set_child_to_copy_structure($structure, $from_structure, $user_id, $next_parent_counter = 0, $body_structure, $parent_number)
    {
        $tree = json_decode($body_structure->tree_representation);
        $parents = $this->get_all_parents($user_id);
        $parents = $this->correct_parents_by_copy_structure($tree, $parents, $body_structure);

        $from_structure_id = $from_structure->id;
        $body_structure_number = $body_structure->number - 1;


        if ($from_structure_id == BinaryStructure::THIRD_STRUCTURE) {
            $user_id = sprintf("%s_%s", $user_id, $body_structure_number * 2);
        } elseif ($from_structure_id == BinaryStructure::FOURTH_STRUCTURE) {
            $user_id = sprintf("%s_%s", $user_id, $body_structure_number * 2 + 1);
        }


        $user_id_items = explode("_", $user_id);
        if (count($user_id_items) == 1) {
            $user_id = sprintf("%s_%s", $user_id, $body_structure_number * 2);
            if (in_array($user_id, $tree)) {
                $user_id = sprintf("%s_%s", $user_id, $body_structure_number * 2 + 1);
            }
        }

        if (isset($parent_number)) {
            $user_id = explode("_", $user_id)[0];
            $user_id = sprintf("%s_%s", $user_id, $parent_number);
        }

        if (count($parents) && !in_array($user_id, $tree)) {
            $exist = in_array($parents[$next_parent_counter], $tree);
            if (!$exist) {
                $user_id = explode("_", $user_id)[0];
                $this->set_child_to_copy_structure($structure, $from_structure, $user_id, $next_parent_counter + 1, $body_structure, $parent_number);
            } else {
                $check = $this->check_free_position($parents[$next_parent_counter], $tree);

                if (!$check) {
                    $user_child = $this->all_child_from_user_by_parent_id($parents[$next_parent_counter], null);
                    $user_child = $this->correct_child_to_copy_structure($tree, $user_child, $body_structure);
                    $tree = $this->set_by_user_child($user_child, $tree, $user_id, $body_structure);
                    return $tree;
                } else {
                    if (!in_array($user_id, $tree)) {
                        $tree = $this->add_child($check['to_place_idx'], $tree, $user_id);
                        $body_structure->tree_representation = json_encode($tree);
                        $body_structure->save();
                        return $tree;
                    }
                }
            }
        }
    }

    public
    function correct_child($tree, $child, $body_structure)
    {
        $array = [];

        foreach ($tree as $child_id) {
            if (in_array($child_id, $child)) {
                array_push($array, $child_id);
            }
        }
        return $array;
    }

    public
    function correct_child_to_copy_structure($tree, $user_child, $body_structure)
    {
        $array = [];
        $mod_user_child = [];
        foreach ($tree as $key => $item) {
            $item = explode("_", $item)[0];
            if (in_array($item, $user_child)) {
                array_push($mod_user_child, $tree[$key]);
            }
        }

        foreach ($tree as $child_id) {
            if (in_array($child_id, $mod_user_child)) {
                array_push($array, $child_id);
            }
        }

        return $array;
    }


    public
    function set_by_user_child($user_child, $tree, $user_id, $body_structure)
    {
        foreach ($user_child as $id) {
            if (in_array($id, $tree)) {
                $result = $this->check_free_position($id, $tree);
                if ($result && !in_array($user_id, $tree)) {
                    $tree = $this->add_child($result['to_place_idx'], $tree, $user_id);
                    $body_structure->tree_representation = json_encode($tree);
                    $body_structure->save();
                    return $tree;
                }
            }
        }
    }


    public
    function correct_parents_by_copy_structure($tree, $parents, $body_structure)
    {
        $array = [];
        $number = $body_structure->number;
        foreach ($parents as $child_id) {
            $child_id_1 = sprintf('%s_%s', $child_id, (($number - 1) * 2));
            $child_id_2 = sprintf('%s_%s', $child_id, (($number - 1) * 2 + 1));

            if (in_array($child_id_1, $tree)) {
                array_push($array, $child_id_1);
            }

            if (in_array($child_id_2, $tree)) {
                array_push($array, $child_id_2);
            }
        }
        return $array;
    }

    public
    function correct_parents($tree, $parents)
    {

        $array = [];
        foreach ($parents as $child_id) {
            if (in_array($child_id, $tree)) {
                array_push($array, $child_id);
            }
        }

        return $array;
    }


    public
    function add_child($to_place_idx, $tree, $user_id)
    {
        $last_count = count($tree);
        for ($i = $last_count; $i <= $to_place_idx; $i++) {
            $tree[$i] = 0;
        }
        $tree[$to_place_idx] = $user_id;
        return $tree;
    }

    public
    function all_child_from_user_by_parent_id($parent_ids, $count = null)
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

    public
    function check_free_position($parent_id, $tree)
    {
        $parent_idx = $this->get_idx_by_user_id($parent_id, $tree);
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

    public
    function get_all_parents($user_id)
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

    public
    function qualificationUp($user_id, $packet_id)
    {
        $user = Users::get_user($user_id);
        $packet = Packet::where(['packet_id' => $packet_id])->first();
        app(PacketController::class)->qualificationUp($packet, $user);
    }

    public
    function set_root($user_id, $structure, $from_structure = null, $structure_body_number, $parent_number = null)
    {
        $copy_structure = false;
        $new_user_number = $parent_number;

        if ($structure_body_number > 1) {
            $copy_structure = true;
            $body_structure = $this->setCopyAdmins($structure, $structure_body_number, $parent_number);
        } else {
            $body_structure = $this->setAdmins($structure, $structure_body_number);
        }

        if ($copy_structure) {

            if (isset($from_structure) && $from_structure->id == BinaryStructure::THIRD_STRUCTURE) {
                $new_user_number = ($structure_body_number - 1) * 2;
            } elseif (isset($from_structure) && $from_structure->id == BinaryStructure::FOURTH_STRUCTURE) {
                $new_user_number = (($structure_body_number - 1) * 2) + 1;
            }

            $user_id = sprintf("%s_%s", $user_id, $new_user_number);
        }

        $tree = json_decode($body_structure->tree_representation);
        if (!in_array($user_id, $tree)) {
            $tree[count($tree)] = $user_id;
        }
        $tree = json_encode($tree);


        $body_structure->tree_representation = $tree;
        $body_structure->save();
    }


    public function setAdmins($structure, $structure_body_number)
    {
        $tree = [2,3
//            ,
//            4,5,6,7,8
        ];
        $tree = json_encode($tree);
        $body_structure = new StructureBody();
        $body_structure->binary_structure_id = $structure->id;
        $body_structure->tree_representation = $tree;
        $body_structure->number = $structure_body_number;
        $body_structure->save();

        return $body_structure;
    }

    public function setCopyAdmins($structure, $structure_body_number, $parent_number)
    {
        $new_user_number = $parent_number;
        if (!isset($parent_number) || $parent_number <= 1) {
            $new_user_number = 2;
        }
        if (!isset($structure_body_number) || $structure_body_number <= 1) {
            $structure_body_number = 2;
        }

        if (isset($from_structure) && $from_structure->id == BinaryStructure::THIRD_STRUCTURE) {
            $new_user_number = ($structure_body_number - 1) * 2;
        } elseif (isset($from_structure) && $from_structure->id == BinaryStructure::FOURTH_STRUCTURE) {
            $new_user_number = (($structure_body_number - 1) * 2) + 1;
        }

        $user_id_2 = sprintf("%s_%s", 2, $new_user_number);
        $user_id_3 = sprintf("%s_%s", 3, $new_user_number);
//        $user_id_4 = sprintf("%s_%s", 4, $new_user_number);
//        $user_id_5 = sprintf("%s_%s", 5, $new_user_number);
//        $user_id_6 = sprintf("%s_%s", 6, $new_user_number);
//        $user_id_7 = sprintf("%s_%s", 7, $new_user_number);
//        $user_id_8 = sprintf("%s_%s", 8, $new_user_number);

        $tree = [
            $user_id_2,
            $user_id_3,
//            $user_id_4,
//            $user_id_5,
//            $user_id_6,
//            $user_id_7,
//            $user_id_8,
        ];
        $tree = json_encode($tree);
        $body_structure = new StructureBody();
        $body_structure->binary_structure_id = $structure->id;
        $body_structure->tree_representation = $tree;
        $body_structure->number = $structure_body_number;
        $body_structure->save();

        return $body_structure;
    }

    public
    function get_first_parent_idx($const_child_idx, $child_idx, $counter, $structure, $body_structure, $packet_id)
    {
        //check is it left child;
        $parent_index = null;
        if ((($child_idx - 1) % 2) == 0) {
            $parent_index = ($child_idx - 1) / 2;
        } else {
            $parent_index = ($child_idx - 2) / 2;
        }
        $counter++;

        if ($parent_index >= 0 && $structure->view_type != BinaryStructure::VIEW_TYPE_ONLY_TRIPLE) {
            $this->give_bonus_to_parent($const_child_idx, $parent_index, $packet_id, $counter, $structure, $body_structure);
        }

        $tillCount = 2;
        if (in_array($structure->id, [BinaryStructure::SECOND_STRUCTURE, BinaryStructure::FOURTH_STRUCTURE])) {
            $tillCount = 1;
        }
        if ($parent_index < 0) {
            return null;
        } else if ($counter == $tillCount) {
            return $parent_index;
        }

        $result = $this->get_first_parent_idx($const_child_idx, $parent_index, $counter, $structure, $body_structure, $packet_id);
        return $result;
    }


    public
    function give_bonus_to_parent($child_idx, $parent_index, $packet_id, $counter, $structure, $body_structure)
    {
        $bonus = 0;
        $packet = (Packet::where(['packet_id' => $packet_id])->first());
        $tree = json_decode($body_structure->tree_representation);
        $binary_percentage = $structure->to_binary_structure;
        $parent_id = $tree[$parent_index];
        $child_id = $tree[$child_idx];
        if ($counter == 1) {
            $bonus = $structure->to_second_parent;
        } elseif ($counter == 2) {
            $bonus = $structure->to_first_parent;
        }


        $packet_price = $packet->packet_price;
        $bonus = ($bonus / 100) * $packet_price;
        $bonus = round($bonus, 0);


        if ($bonus) {
            try {
                DB::beginTransaction();

                $parent_user = Users::where('user_id', '=', $parent_id)->first();
                $parent_user = !isset($parent_user) ?
                    DB::table('users')->where(['user_id' => $parent_id])->first() :
                    Users::find($parent_id);

                DB::table('users')->where(['user_id' => (int)$parent_id])->update([
                    'user_money' => $parent_user->user_money + $bonus,
                ]);

                $operation = new UserOperation();
                $operation->author_id = $child_id;
                $operation->recipient_id = $parent_id;
                $operation->money = $bonus;
                $operation->operation_id = 1;
                $operation->operation_type_id = 17;
                $operation->operation_comment = sprintf('Стол: %s, номер стола: %s. Бинарный доход %s$ (%s) тг', $packet->packet_name_ru, $body_structure->number, $bonus, $bonus * Currency::usdToKzt());
                $operation->save();

                DB::commit();
            } catch (\Exception $e) {
                var_dump($e->getMessage());
                var_dump($parent_id);
                DB::rollback();
            }
        }

    }

    public
    function check_parents_has_enough_to_next_tree($parent_index, $body_structure)
    {
        $tree = json_decode($body_structure->tree_representation);
        $structure = BinaryStructure::where(['id' => $body_structure->binary_structure_id])->first();

        $left_child_idx = $this->get_left_child_idx($parent_index);
        $right_child_idx = $this->get_right_child_idx($parent_index);

        if (!(isset($tree[$left_child_idx]) && $tree[$left_child_idx]) ||
            !(isset($tree[$right_child_idx]) && $tree[$right_child_idx])) {
            return false;
        }

        if (in_array($structure->id, [BinaryStructure::SECOND_STRUCTURE, BinaryStructure::FOURTH_STRUCTURE])) {
            return true;
        }

        $left_left_child_idx = $this->get_left_child_idx($left_child_idx);
        $left_right_child_idx = $this->get_left_child_idx($left_child_idx);

        if (!(isset($tree[$left_left_child_idx]) && $tree[$left_left_child_idx]) ||
            !(isset($tree[$left_right_child_idx]) && $tree[$left_right_child_idx])) {
            return false;
        }


        $right_left_child_idx = $this->get_left_child_idx($right_child_idx);
        $right_right_child_idx = $this->get_right_child_idx($right_child_idx);

        if (!(isset($tree[$right_left_child_idx]) && $tree[$right_left_child_idx]) ||
            !(isset($tree[$right_right_child_idx]) && $tree[$right_right_child_idx])) {
            return false;
        }

        return true;


    }

    public
    function get_idx_by_user_id($user_id, $tree)
    {
        $user_idx = array_search($user_id, array_values($tree));
        return $user_idx;
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
