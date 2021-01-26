<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class TreeImplementation extends Model
{

    public function firstStructure($user_id, $number = 1, $isVip = false)
    {
        try {
            $binaryStructureId = $this->getBinaryStructureId(BinaryStructure::FIRST_STRUCTURE, $isVip);

            $this->initStructureBody($binaryStructureId, $number, $isVip);


            $result = $this->setUserToTree($binaryStructureId, $number, $user_id);

            if (!$result['success']) {
                return
                    [
                        'success' => false,
                        'message' => $result['message'],
                    ];
            }


            $structureBody = $structureBody = $result['data'];

            Operation::recordUpToNextTree($user_id, $number, $structureBody);

            $tree = $result['tree'];
            $result = $this->checkParent($user_id, $structureBody, $tree);

            if ($result['parentToNextTree'] && $structureBody = $this->secondStructure($result['parentId'], $number, $isVip)) {
                Operation::recordUpToNextTree($result['parentId'], $number, $structureBody);
            }
            return [
                'success' => true,
                'message' => null,
            ];
        } catch
        (\Exception $exception) {
            $message = sprintf('Ошибка %s', $exception->getFile() . ' / ' . $exception->getLine() . ' / ' . $exception->getMessage());
            return [
                'success' => false,
                'message' => $message,
            ];
        }

    }

    public function secondStructure($user_id, $number = 1, $isVip = false)
    {
        $binaryStructureId = $this->getBinaryStructureId(BinaryStructure::SECOND_STRUCTURE, $isVip);
        $this->initStructureBody($binaryStructureId, $number, $isVip);

        $result = $this->setUserToTree($binaryStructureId, $number, $user_id);

        if (!$result['success']) {
            return false;
        }
        $structureBody = $result['data'];
        $tree = $result['tree'];
        $result = $this->checkParent($user_id, $structureBody, $tree);

        if ($result['parentToNextTree'] && $this->thirdStructure($result['parentId'], $number, $isVip)) {
            Operation::recordUpToNextTree($result['parentId'], $number, $structureBody);
        }

        return $structureBody;
    }

    public function thirdStructure($user_id, $number = 1, $isVip = false)
    {
        $binaryStructureId = $this->getBinaryStructureId(BinaryStructure::THIRD_STRUCTURE, $isVip);
        $this->initStructureBody($binaryStructureId, $number, $isVip);

        $result = $this->setUserToTree($binaryStructureId, $number, $user_id);

        if (!$result['success']) {
            return false;
        }
        $structureBody = $result['data'];
        $tree = $result['tree'];
        $result = $this->checkParent($user_id, $structureBody, $tree);

        if ($result['parentToNextTree'] && $fourthStructureBody = $this->fourthStructure($result['parentId'], $number, $isVip)) {
            Operation::recordUpToNextTree($result['parentId'], $number, $fourthStructureBody);
        }
        if ($result['parentToNextTree']) {
            $number = $number + 1;
            $resultFromInvestment = $this->firstStructure($result['parentId'], $number, $isVip);
            if ($resultFromInvestment['success']) {
                Operation::recordReinvestment($result['parentId'], $number, $isVip);
            }
        }

        return $structureBody;
    }

    public function fourthStructure($user_id, $number = 1, $isVip = false)
    {
        $binaryStructureId = $this->getBinaryStructureId(BinaryStructure::FOURTH_STRUCTURE, $isVip);
        $this->initStructureBody($binaryStructureId, $number, $isVip);

        $result = $this->setUserToTree($binaryStructureId, $number, $user_id);
        if (!$result['success']) {
            return false;
        }
        $structureBody = $result['data'];
        $tree = $result['tree'];
        $result = $this->checkParent($user_id, $structureBody, $tree);

        if ($result['parentToNextTree'] && $fifthStructureBody = $this->fifthStructure($result['parentId'], $number, $isVip)) {
            Operation::recordUpToNextTree($result['parentId'], $number, $fifthStructureBody);
        }
        if ($result['parentToNextTree']) {
            $number = $number + 1;
            $resultFromInvestment = $this->firstStructure($result['parentId'], $number, $isVip);
            if ($resultFromInvestment['success']) {
                Operation::recordReinvestment($result['parentId'], $number, $isVip);
            }
        }

        return $structureBody;
    }

    public function fifthStructure($user_id, $number = 1, $isVip = false)
    {
        $binaryStructureId = $this->getBinaryStructureId(BinaryStructure::FIFTH_STRUCTURE, $isVip);
        $this->initStructureBody($binaryStructureId, $number, $isVip);

        $result = $this->setUserToTree($binaryStructureId, $number, $user_id);


        if (!$result['success']) {
            return false;
        }
        $structureBody = $result['data'];
        $tree = $result['tree'];
        $this->checkParent($user_id, $structureBody, $tree);


        return $structureBody;
    }

    public function initStructureBody($binaryStructureId, $number, $isVip = false)
    {
        $structureBodyObject = $this->getStructureBodyType($isVip);

        $redis = new Redis();
        $structureName = BinaryStructure::where(['id' => $binaryStructureId])->first()->type;
        $data = $redis::zRange($structureName . ':' . $number, 0, -1, 'WITHSCORES');
        $BinaryStructureIsExist = empty($data);
        if ($BinaryStructureIsExist) {
            $structureBodyObject->setRootUsersToStructureBody($binaryStructureId, $number);
        }
    }

    public function checkParent($user_id, $structureBody, $tree)
    {
        // check parent has enough child to next tree
        $userPosition = StructureBody::getTreePositionByUserId($user_id, $structureBody, $tree);
        $treeParentPosition = (new StructureBody)->getTreeParentId($userPosition, $structureBody, $tree);

        $treeParentId = StructureBody::getIdByPosition($treeParentPosition, $tree);

        $checkParent = StructureBody::parentHasEnoughChild($treeParentPosition, $structureBody, $tree);

        return [
            'parentToNextTree' => $checkParent,
            'parentId' => $treeParentId,
        ];
    }


    public function setUserToTree($binaryStructureId, $number, $user_id)
    {
        if ($binaryStructureId <= BinaryStructure::FIFTH_STRUCTURE) {
            $structureBody = (new StructureBody)->getStructureBody($binaryStructureId, $number);
        } else {
            $structureBody = (new VipStructureBody)->getStructureBody($binaryStructureId, $number);
        }


        $redis = new Redis();
        $structureName = BinaryStructure::where(['id' => $binaryStructureId])->first()->type;
        $redis_key = $structureName . ':' . $number;
        $tree = $redis::zRange($redis_key, 0, -1, 'WITHSCORES');

        if ($number == 1) {
            $isUserExistInTree = in_array($user_id, $tree);
            $message = 'Такой пользователь уже существует в системе !';
        } else {
            $isUserExistInTree = in_array($user_id, $tree) && array_count_values($tree)[$user_id] >= 2;
            $message = 'Такой пользователь уже существует в системе дважды !';
        }

        if (!$isUserExistInTree) {

            $position = StructureBody::getPosition($user_id, $tree);


            if (!$position) {
                return [
                    'success' => false,
                    'message' => 'Система не нашла корректную позицию',
                ];
            }

            $tree[$position] = $user_id;
            $redis::zAdd($redis_key, $user_id, $position);

        } else {
            return [
                'success' => false,
                'message' => $message,
            ];
        }
        return [
            'success' => true,
            'message' => null,
            'tree' => $tree,
            'data' => $structureBody,
        ];
    }

    public function getBinaryStructureId($binaryStructureId, $isVip = false)
    {
        if ($isVip) {
            $binaryStructureId = BinaryStructure::FIFTH_STRUCTURE + $binaryStructureId;
        }
        return $binaryStructureId;
    }

    public function getStructureBodyType($isVip = false)
    {
        if ($isVip) {
            $structureBody = new VipStructureBody();
        } else {
            $structureBody = new StructureBody();
        }

        return $structureBody;
    }


}
