<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\BinaryStructure;
use App\Models\Currency;
use App\Models\Fond;
use App\Models\Operation;
use App\Models\Packet;
use App\Models\UserOperation;
use App\Models\UserPacket;
use App\Models\Users;
use App\Models\UserStatus;
use DB;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;
use URL;
use View;

class PacketController extends Controller
{
    public $sentMoney = 0;

    public function __construct()
    {
        $this->middleware('profile', ['except' => ['AcceptUserPacketPayBox', 'implementPacketBonuses']]);
        $this->middleware('admin', ['only' => ['inactiveUserPacket', 'activeUserPacket', 'deleteInactiveUserPacket', 'acceptInactiveUserPacket']]);
    }

    public function getPacketById($id)
    {
        $packet = Packet::find($id);
        $result['status'] = false;
        $result['title'] = $packet->packet_name_ru;
        $result['desc'] = $packet->packet_desc_ru;
        $result['image'] = '<a class="fancybox" href="' . $packet->packet_image . '">
                                     <img src="' . $packet->packet_image . '" style="width:100%">
                                 </a>';
        return response()->json($result);
    }

    public function activeUserPacket(Request $request)
    {
        $row = UserPacket::leftJoin('users', 'users.user_id', '=', 'user_packet.user_id')
            ->leftJoin('packet', 'packet.packet_id', '=', 'user_packet.packet_id')
            ->leftJoin('users as recommend', 'recommend.user_id', '=', 'users.recommend_user_id')
            ->leftJoin('city', 'city.city_id', '=', 'users.city_id')
            ->leftJoin('country', 'country.country_id', '=', 'city.country_id')
            ->where('user_packet.is_active', 1)
            ->orderBy('user_packet.user_packet_id', 'desc')
            ->select('users.*', 'user_packet.*', 'packet.*', 'city.*', 'country.*',
                'recommend.name as recommend_name',
                'recommend.user_id as recommend_id',
                'recommend.login as recommend_login',
                'recommend.last_name as recommend_last_name',
                'recommend.user_id as recommend_user_id',
                DB::raw('DATE_FORMAT(user_packet.created_at,"%d.%m.%Y %H:%i") as date'));

        if (isset($request->user_name) && $request->user_name != '')
            $row->where(function ($query) use ($request) {
                $query->where('users.name', 'like', '%' . $request->user_name . '%')
                    ->orWhere('users.last_name', 'like', '%' . $request->user_name . '%')
                    ->orWhere('users.login', 'like', '%' . $request->user_name . '%')
                    ->orWhere('users.email', 'like', '%' . $request->user_name . '%')
                    ->orWhere('users.middle_name', 'like', '%' . $request->user_name . '%');
            });

        if (isset($request->sponsor_name) && $request->sponsor_name != '')
            $row->where(function ($query) use ($request) {
                $query->where('recommend.name', 'like', '%' . $request->sponsor_name . '%')
                    ->orWhere('recommend.last_name', 'like', '%' . $request->sponsor_name . '%')
                    ->orWhere('recommend.login', 'like', '%' . $request->sponsor_name . '%')
                    ->orWhere('recommend.email', 'like', '%' . $request->sponsor_name . '%')
                    ->orWhere('recommend.middle_name', 'like', '%' . $request->sponsor_name . '%');
            });

        if (isset($request->packet_name) && $request->packet_name != '')
            $row->where(function ($query) use ($request) {
                $query->where('packet.packet_name_ru', 'like', '%' . $request->packet_name . '%');
            });

        if (isset($request->date_from) && $request->date_from != '') {
            $timestamp = strtotime($request->date_from);
            $row->where(function ($query) use ($timestamp) {
                $query->where('user_packet.created_at', '>=', date("Y-m-d H:i", $timestamp));
            });
        }

        if (isset($request->date_to) && $request->date_to != '') {
            $timestamp = strtotime($request->date_to);
            $row->where(function ($query) use ($timestamp) {
                $query->where('user_packet.created_at', '<=', date("Y-m-d H:i", $timestamp));
            });
        }

        $row = $row->paginate(10);

        return view('admin.active-user-packet.packet', [
            'row' => $row,
            'request' => $request
        ]);
    }

    public function inactiveUserPacket(Request $request)
    {
        $row = UserPacket::leftJoin('users', 'users.user_id', '=', 'user_packet.user_id')
            ->leftJoin('packet', 'packet.packet_id', '=', 'user_packet.packet_id')
            ->leftJoin('users as recommend', 'recommend.user_id', '=', 'users.recommend_user_id')
            ->where('user_packet.is_active', 0)
            ->orderBy('user_packet.user_packet_id', 'desc')
            ->select('users.*', 'user_packet.*', 'packet.*',
                'recommend.name as recommend_name',
                'recommend.user_id as recommend_id',
                'recommend.login as recommend_login',
                'recommend.last_name as recommend_last_name',
                'recommend.user_id as recommend_user_id',
                DB::raw('DATE_FORMAT(user_packet.created_at,"%d.%m.%Y %H:%i") as date'));

        if (isset($request->user_name) && $request->user_name != '')
            $row->where(function ($query) use ($request) {
                $query->where('users.name', 'like', '%' . $request->user_name . '%')
                    ->orWhere('users.last_name', 'like', '%' . $request->user_name . '%')
                    ->orWhere('users.login', 'like', '%' . $request->user_name . '%')
                    ->orWhere('users.email', 'like', '%' . $request->user_name . '%')
                    ->orWhere('users.middle_name', 'like', '%' . $request->user_name . '%');
            });

        if (isset($request->sponsor_name) && $request->sponsor_name != '')
            $row->where(function ($query) use ($request) {
                $query->where('recommend.name', 'like', '%' . $request->sponsor_name . '%')
                    ->orWhere('recommend.last_name', 'like', '%' . $request->sponsor_name . '%')
                    ->orWhere('recommend.login', 'like', '%' . $request->sponsor_name . '%')
                    ->orWhere('recommend.email', 'like', '%' . $request->sponsor_name . '%')
                    ->orWhere('recommend.middle_name', 'like', '%' . $request->sponsor_name . '%');
            });

        if (isset($request->packet_name) && $request->packet_name != '')
            $row->where(function ($query) use ($request) {
                $query->where('packet.packet_name_ru', 'like', '%' . $request->packet_name . '%');
            });

        $row = $row->paginate(10);

        return view('admin.inactive-user-packet.packet', [
            'row' => $row,
            'request' => $request
        ]);
    }

    public function sendResponseAddPacket(Request $request)
    {
        $packet = Packet::where('packet_id', $request->packet_id)->first();
        if ($packet == null) {
            $result['message'] = 'Такого пакета не существует';
            $result['status'] = false;
            return response()->json($result);
        }

        if ($packet->condition_minimum_status_id > 0) {

            $status = UserStatus::where('user_status_id', Auth::user()->status_id)->first();
            $status_condition = UserStatus::where('user_status_id', $packet->condition_minimum_status_id)->first();

            if ($status == null || $status->sort_num < $status_condition->sort_num) {
                $result['message'] = 'У вас должно быть статус - ' . $status_condition->user_status_name . " и выше";
                $result['status'] = false;
                return response()->json($result);
            }
        }

        if (in_array($packet->is_upgrade_packet, [1, 3])) {
            $is_check = UserPacket::leftJoin('packet', 'packet.packet_id', '=', 'user_packet.packet_id')
                ->where('user_id', Auth::user()->user_id)
                ->where('user_packet.is_active', '=', '0')
                ->where('upgrade_type', '=', $packet->upgrade_type)
                ->count();

            if ($is_check > 0) {
                $result['message'] = 'Вы уже отправили запрос на другой пакет, сначала отмените тот запрос';
                $result['status'] = false;
                return response()->json($result);
            }

            if ($request->packet_id > 2) {
                $is_check = UserPacket::leftJoin('packet', 'packet.packet_id', '=', 'user_packet.packet_id')
                    ->where('user_packet.user_id', Auth::user()->user_id)
                    ->where('user_packet.packet_id', '>=', $request->packet_id)
                    ->where('upgrade_type', '=', $packet->upgrade_type)
                    ->where('user_packet.is_active', 1)
                    ->count();

                if ($is_check > 0) {
                    $result['message'] = 'Вы не можете купить этот пакет, так как вы уже приобрели другой пакет';
                    $result['status'] = false;
                    return response()->json($result);
                }
            }
        }

        $is_check = UserPacket::where('user_id', Auth::user()->user_id)->where('packet_id', '=', $request->packet_id)->count();
        if ($is_check > 0) {
            $result['message'] = 'Вы уже отправили запрос на этот пакет';
            $result['status'] = false;
            return response()->json($result);
        }


        $packet = Packet::where('packet_id', $request->packet_id)->first();

        $user_packet = new UserPacket();
        $user_packet->user_id = Auth::user()->user_id;
        $user_packet->packet_id = $request->packet_id;
        $user_packet->user_packet_type = $request->user_packet_type;
        $user_packet->packet_price = $packet->packet_price;
        $user_packet->is_active = 0;
        $user_packet->is_portfolio = $packet->is_portfolio;
        $user_packet->save();

        $result['message'] = 'Вы успешно отправили запрос';
        $result['status'] = true;
        return response()->json($result);
    }

    public function buyPacketFromBalance(Request $request)
    {
        $packet = Packet::where('packet_id', $request->packet_id)->first();
        if ($packet == null) {
            $result['message'] = 'Такого пакета не существует';
            $result['status'] = false;
            return response()->json($result);
        }

        $is_check = UserPacket::leftJoin('packet', 'packet.packet_id', '=', 'user_packet.packet_id')
            ->where('user_id', Auth::user()->user_id)
            ->where('is_active', '=', '0')
            ->where('upgrade_type', '=', $packet->upgrade_type)
            ->count();

        if ($is_check > 0) {
            $result['message'] = 'Вы уже отправили запрос на другой пакет, сначала отмените тот запрос';
            $result['status'] = false;
            return response()->json($result);
        }

        if ($request->packet_id > 2) {
            $is_check = UserPacket::leftJoin('packet', 'packet.packet_id', '=', 'user_packet.packet_id')
                ->where('user_packet.user_id', Auth::user()->user_id)
                ->where('user_packet.packet_id', '>=', $request->packet_id)
                ->where('upgrade_type', '=', $packet->upgrade_type)
                ->where('user_packet.is_active', 1)
                ->count();

            if ($is_check > 0) {
                $result['message'] = 'Вы не можете купить этот пакет, так как вы уже приобрели другой пакет';
                $result['status'] = false;
                return response()->json($result);
            }
        }


        $is_check = UserPacket::where('user_id', Auth::user()->user_id)->where('packet_id', '=', $request->packet_id)->count();
        if ($is_check > 0) {
            $result['message'] = 'Вы уже отправили запрос на этот пакет';
            $result['status'] = false;
            return response()->json($result);
        }
        if (Auth::user()->user_money < $packet->packet_price) {
            $result['message'] = 'У вас не хватает баланса чтобы купить этот пакет';
            $result['status'] = false;
            return response()->json($result);
        }


        $packet = Packet::where('packet_id', $request->packet_id)->first();

        $user_packet = new UserPacket();
        $user_packet->user_id = Auth::user()->user_id;
        $user_packet->packet_id = $request->packet_id;
        $user_packet->user_packet_type = $request->user_packet_type;
        $user_packet->packet_price = $packet->packet_price;
        $user_packet->is_active = 0;
        $user_packet->is_portfolio = $packet->is_portfolio;
        $user_packet->save();

        $operation = new UserOperation();
        $operation->author_id = Auth::user()->user_id;
        $operation->recipient_id = null;
        $operation->money = $packet->packet_id == $packet->packet_price;
        $operation->operation_id = 2;
        $operation->operation_type_id = 30;
        $operation->operation_comment = $request->comment;
        $operation->save();

        $users = Users::find(Auth::user()->user_id);

        $rest_mooney = $users->user_money - $packet->packet_price;
        $users->user_money = $rest_mooney;
        $users->save();

        try {
            $isImplementPacketBonus = $this->implementPacketBonuses($user_packet->user_packet_id);
        } catch (\Exception $exception) {
            $users->user_money = $users->user_money + $packet->packet_price;
            $users->save();
        }


        $result['message'] = 'Вы успешно купили пакет';
        $result['result'] = $isImplementPacketBonus;
        $result['status'] = true;
        return response()->json($result);
    }

    public function cancelResponsePacket(Request $request)
    {
        $is_check = UserPacket::where('user_id', Auth::user()->user_id)
            ->where('packet_id', $request->packet_id)
            ->where('is_active', 0)
            ->first();

        if ($is_check == null) {
            $result['message'] = 'Такого запроса не существует';
            $result['status'] = false;
            return response()->json($result);
        }

        $is_check->delete();

        $result['message'] = 'Вы успешно отменили запрос';
        $result['status'] = true;
        return response()->json($result);
    }

    public function deleteInactiveUserPacket(Request $request)
    {
        $user_packet = UserPacket::find($request->packet_id);
        $user_packet->forceDelete();
    }

    public function acceptInactiveUserPacket(Request $request)
    {
        $result = [];
        $user_packet_id = $request->packet_id;
        $user_packet = UserPacket::where(['user_packet_id' => $user_packet_id])->first();

        $packet_id = $user_packet->packet_id;
        $user_id = $user_packet->user_id;
        $structure_id = BinaryStructure::get_structure_by_packet_id($packet_id);
        $structure = BinaryStructure::where(['id' => $structure_id])->first();
        $tree = json_decode($structure->tree_representation);
        if (in_array($user_id, $tree)) {
            $result['message'] = 'В бинарной структуре уже имеется такой пользователь';
            $result['status'] = false;
            return response()->json($result);
        }

        if ($user_packet) {
            $user_id = $user_packet->user_id;
            $packet_id = $user_packet->packet_id;
            try {
                $result = $this->implementPacketBonuses($user_packet->user_packet_id);
                if(!$result['status']){
                    return $result = [
                        'message' => $result['message'],
                        'status' => false,
                    ];
                }
            } catch (\Exception $exception) {
                $user = Users::get_user($user_id);
                $packet = Packet::where(['packet_id' => $packet_id])->first();
                $user->user_money = $user->user_money + $packet->packet_price;
                $user->save();
            }

            $result['message'] = 'Вы успешно приняли запрос';
            $result['status'] = true;
        }
        return response()->json($result);
    }

    public function implementPacketBonuses($userPacketId)
    {
        $userPacket = UserPacket::find($userPacketId);
        if (!isset($userPacket)) {
            $userPacket = UserPacket::where(['user_packet_id' => $userPacketId])->first();
        }


        if (!$userPacket) {
            $result['message'] = 'Ошибка';
            $result['status'] = false;
            return $result;
        }

        $packet = Packet::where(['packet_id' => $userPacket->packet_id])->first();
        $user = Users::where(['user_id' => $userPacket->user_id])->first();

        if (!$packet || !$user) {
            $result['message'] = 'Ошибка, пользователь, пригласитель или пакет был не найден!';
            $result['status'] = false;
            return $result;
        }
        $result= $this->activatePackage($userPacket);

        if(!$result['status']){
            return $result = [
                'status' => false,
                'message' => $result['message'],
            ];
        }
        return [
            'status' => true,
            'message' => 'success',
        ];

    }

    private function activatePackage($userPacket)
    {
        if ($userPacket == null || $userPacket->is_active == 1) {
            $result['message'] = 'ошибка';
            $result['status'] = false;

        }

        $userPacket->is_active = 1;
        $max_queue_start_position = UserPacket::where('packet_id', $userPacket->packet_id)->where('is_active', 1)->where('queue_start_position', '>', 0)->max('queue_start_position');
        $userPacket->queue_start_position = ($max_queue_start_position) ? ($max_queue_start_position + 1) : 1;
        if ($userPacket->save()) {
            Users::where('user_id', $userPacket->user_id)->update(['product_balance' => $userPacket->packet_price]);
            app(ClassicalStructureController::class)->implement_bonuses($userPacket->user_packet_id);
            app(BinaryStructureController::class)->to_next_structure($userPacket->user_id, $userPacket->packet_id, null, $userPacket->user_packet_id);
            $user = Users::get_user($userPacket->user_id);
            $packet = Packet::where(['packet_id' => $userPacket->packet_id])->first();
            $this->qualificationUp($packet, $user);
        }

        return [
            'status' => true,
            'message' => 'success',
        ];
    }

    public
    function qualificationUp($packet, $user)
    {
        $actualPackets = [
            Packet::SILVER,
            Packet::GOLD,
            Packet::PLATINUM,
            Packet::RUBIN,
            Packet::SAPPHIRE,
            Packet::EMERALD,
            Packet::DIAMOND
        ];
        if (in_array($packet->packet_id, $actualPackets)) {

            $operation = new UserOperation();
            $operation->author_id = null;
            $operation->recipient_id = $user->user_id;
            $operation->money = null;
            $operation->operation_id = 1;
            $operation->operation_type_id = 10;

            if ($packet->packet_status_id == UserStatus::SILVER)
                $operation->operation_comment = 'Ваш статус Silver стол';
            elseif ($packet->packet_status_id == UserStatus::GOLD)
                $operation->operation_comment = 'Ваш статус Gold стол';
            elseif ($packet->packet_status_id == UserStatus::PLATINUM)
                $operation->operation_comment = 'Ваш статус Platinum стол';
            elseif ($packet->packet_status_id == UserStatus::RUBIN)
                $operation->operation_comment = 'Ваш статус Rubin стол';
            elseif ($packet->packet_status_id == UserStatus::SAPPHIRE)
                $operation->operation_comment = 'Ваш статус Sapphire стол';
            elseif ($packet->packet_status_id == UserStatus::EMERALD)
                $operation->operation_comment = 'Ваш статус Emerald стол';
            elseif ($packet->packet_status_id == UserStatus::DIAMOND)
                $operation->operation_comment = 'Ваш статус Diamond стол';

            $operation->save();
            $user->status_id = $packet->packet_status_id;
            $user->save();
        }
    }

}
