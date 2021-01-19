<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operation extends Model
{
    protected $table = 'operation';
    protected $primaryKey = 'operation_id';

    use SoftDeletes;

    protected $dates = ['deleted_at'];


    const CHARGING = 1;
    const CASH_WITHDRAWAL = 2;

    const RefillGlobalDiamondFound = 33;
    const GlobalBonus = 34;


    public static function recordOperation(array $data)
    {
        $operation = new UserOperation();
        $operation->author_id = $data['author_id'];
        $operation->recipient_id = $data['recipient_id'];
        $operation->money = $data['money'];
        $operation->operation_id = $data['operation_id'];
        $operation->operation_type_id = $data['operation_type_id'];
        $operation->operation_comment = $data['comment'];
        $operation->save();
    }

    public static function recordReinvestment($user_id, $number, $isVip)
    {
        if ($isVip) {
            $structureBody = VipStructureBody::where(['binary_structure_id' => BinaryStructure::SIXTH_STRUCTURE])
                ->where(['number' => $number])
                ->first();
        } else {
            $structureBody = StructureBody::where(['binary_structure_id' => BinaryStructure::FIRST_STRUCTURE])
                ->where(['number' => $number])
                ->first();
        }

        $data = [
            'author_id' => null,
            'recipient_id' => $user_id,
            'money' => 0,
            'operation_id' => 1,
            'operation_type_id' => 10,
            'comment' => sprintf('Реинвестирование, покупка первого стола на сумму 10000тг на закрытие %s - го стола, номер стола %s.',
                $structureBody->binary_structure_id, $structureBody->number),
        ];
        Operation::recordOperation($data);
    }

    public static function recordSendReward($childId, $parentId, $bonus, $structureBody)
    {
        $data = [
            'author_id' => $childId,
            'recipient_id' => $parentId,
            'money' => $bonus,
            'operation_id' => 1,
            'operation_type_id' => 17,
            'comment' =>
                sprintf('Стол: %s, номер стола: %s. Бинарный доход %s$ (%s) тг',
                    $structureBody->structure->name_ru,
                    $structureBody->number,
                    $bonus,
                    $bonus * Currency::usdToKzt())
        ];
        Operation::recordOperation($data);
    }

    public static function recordUpToNextTree($userId, $number, $structureBody)
    {
        $user = Users::where(['user_id' => $userId])->first();
        $packetId = Packet::getPacketIdByBinaryStructure($structureBody->binary_structure_id);
        $packet = Packet::where(['packet_id' => $packetId])->first();
        $number = isset($number) ? $number : 1;
        $comment = sprintf('Ваш статус %s, номер стола: %s', $structureBody->structure->name_ru, $number);
        $data = [
            'author_id' => null,
            'recipient_id' => $userId,
            'money' => null,
            'operation_id' => 1,
            'operation_type_id' => 10,
            'comment' => $comment,

        ];
        self::recordOperation($data);
        $user->status_id = $packet->packet_status_id;
        $user->save();
    }

    public static function recordSendMoneyToPayee($authorId, $recipientId, $money)
    {
        $comment = sprintf('Кураторский бонус в размере %s (%s)', $money, $money * Currency::usdToKzt());
        $data = [
            'author_id' => $authorId,
            'recipient_id' => $recipientId,
            'money' => $money,
            'operation_id' => 1,
            'operation_type_id' => 40,
            'comment' => $comment,
        ];
        self::recordOperation($data);
    }
}
