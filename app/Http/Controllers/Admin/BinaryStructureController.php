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
use Illuminate\Support\Facades\Redis;
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

        return view('admin.binary_structure.show', [
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
}
