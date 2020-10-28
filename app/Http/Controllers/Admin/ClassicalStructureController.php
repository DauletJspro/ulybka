<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Packet;
use App\Models\UserOperation;
use App\Models\UserPacket;
use App\Models\Users;
use Illuminate\Support\Facades\DB;

class ClassicalStructureController extends Controller
{
    public function implement_bonuses(int $user_packet_id, int $packet_id = null)
    {
        $bonus = 1;

        $user_packet = UserPacket::where(['user_packet_id' => $user_packet_id])
            ->where(['is_active' => true])
            ->first();

        if (!$user_packet) {
            return [
                'success' => false,
                'message' => 'User packet not found',
            ];
        }

        $user = Users::where(['user_id' => $user_packet->user_id])->first();
        $parent = Users::where(['user_id' => $user->recommend_user_id])->first();
        $counter = 1;
        while ($parent) {

            if ($counter >= 9 || $parent->user_id == 1) {
                break;
            }

            $money = $parent->user_money + $bonus;
            $parent->user_money = $money;
            if ($parent->save()) {
                $this->record_operation($user_packet, $parent, $bonus, $counter, $packet_id);
            }
            $parent = Users::where(['user_id' => $parent->recommend_user_id])->first();
            $counter++;

        }
        if ($counter < 9) {
            $adminUser = Users::where(['user_id' => 1])->first(); // get Admin
            $rest_money = 9 - $counter;
            $adminUser->user_money = $adminUser->user_money + $rest_money;
            if ($adminUser->save()) {
                $this->record_operation($user_packet, $adminUser, $rest_money, $counter, $packet_id);
            }
        }
    }

    public function record_operation($user_packet, $parent, $bonus, $counter, $packet_id = null)
    {
        $packet = Packet::where(['packet_id' => $user_packet->packet_id])->first();
        if (isset($packet_id)) {
            $packet = Packet::where(['packet_id' => $packet_id])->first();
        }

        $moneyInKzt = $bonus * Currency::usdToKzt();
        $operation = new UserOperation();
        $operation->author_id = $user_packet->user_id;
        $operation->recipient_id = $parent->user_id;
        $operation->money = $bonus;
        $operation->operation_id = 1;
        $operation->operation_type_id = 1;
        $operation->operation_comment = sprintf('Уровень: %s. Рекрутинговый бонус. За %s. Уровень - %s. Бонус в размере %s$ (%s тг)', $packet->packet_name_ru, $packet->packet_name_ru, $counter, $bonus, $moneyInKzt);
        $operation->save();
    }
}