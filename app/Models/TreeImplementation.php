<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Psy\Util\Json;

class TreeImplementation extends Model
{

    public function firstStructure($user_id, $number = 1, $isVip = false)
    {
        try {
            $binaryStructureId = $this->getBinaryStructureId(BinaryStructure::FIRST_STRUCTURE, $isVip);

            $structureBody = $this->initStructureBody($binaryStructureId, $number, $isVip);

            $result = $this->setUserToTree($structureBody, $user_id);

            if (!$result['success']) {
                return
                    [
                        'success' => false,
                        'message' => $result['message'],
                    ];
            }

            Operation::recordUpToNextTree($user_id, $number, $structureBody);

            $structureBody = $result['data'];
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
        $structureBody = $this->initStructureBody($binaryStructureId, $number, $isVip);

        $result = $this->setUserToTree($structureBody, $user_id);

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
        $structureBody = $this->initStructureBody($binaryStructureId, $number, $isVip);

        $result = $this->setUserToTree($structureBody, $user_id);

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
                Operation::recordReinvestment($result['parentId'], $number);
            }
        }

        return $structureBody;
    }

    public function fourthStructure($user_id, $number = 1, $isVip = false)
    {
        $binaryStructureId = $this->getBinaryStructureId(BinaryStructure::FOURTH_STRUCTURE, $isVip);
        $structureBody = $this->initStructureBody($binaryStructureId, $number, $isVip);

        $result = $this->setUserToTree($structureBody, $user_id);
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
                Operation::recordReinvestment($result['parentId'], $number);
            }
        }

        return $structureBody;
    }

    public function fifthStructure($user_id, $number = 1, $isVip = false)
    {
        $binaryStructureId = $this->getBinaryStructureId(BinaryStructure::FIFTH_STRUCTURE, $isVip);
        $structureBody = $this->initStructureBody($binaryStructureId, $number, $isVip);

        $result = $this->setUserToTree($structureBody, $user_id);


        if (!$result['success']) {
            return false;
        }
        $structureBody = $result['data'];

        return $structureBody;
    }

    public function initStructureBody($binaryStructureId, $number, $isVip = false)
    {
        $structureBodyObject = $this->getStructureBodyType($isVip);
        $structureBody = ($structureBodyObject)->getStructureBody($binaryStructureId, $number);

        $BinaryStructureIsExist = isset($structureBody);

        if (!$BinaryStructureIsExist) {
            $structureBody = ($structureBodyObject)->setRootUsersToStructureBody($binaryStructureId, $number);
        }

        return $structureBody;
    }

    public function checkParent($user_id, $structureBody, $tree)
    {
        // check parent has enough child to next tree
        $userPosition = StructureBody::getTreePositionByUserId($user_id, $structureBody, $tree);
        $treeParentPosition = (new StructureBody)->getTreeParentId($userPosition, $structureBody);

        $treeParentId = StructureBody::getIdByPosition($treeParentPosition, $tree);

        $checkParent = StructureBody::parentHasEnoughChild($treeParentPosition, $structureBody, $tree);

        return [
            'parentToNextTree' => $checkParent,
            'parentId' => $treeParentId,
        ];
    }


    public function setUserToTree($structureBody, $user_id)
    {
        $number = $structureBody->number;
        $tree = (new StructureBody)->getStructureBodyTreeRepresentation($structureBody);
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
            // fill empty positions by zero
            for ($i = count($tree); $i < $position; $i++) {
                $tree[$i] = 0;
            }

            $tree[$position] = $user_id;
            $structureBody->tree_representation = JSON::encode($tree);
            $structureBody->save();
        } else {
            return [
                'success' => false,
                'message' => $message,
            ];
        }
        return [
            'success' => true,
            'message' => null,
            'data' => $structureBody,
            'tree' => $tree
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
