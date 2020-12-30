<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreeImplementation extends Model
{
    public function firstStructure($user_id, $number = 1)
    {
        try {
            $structureBody = $this->initStructureBody(BinaryStructure::FIRST_STRUCTURE, $number);
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
            $result = $this->checkParent($user_id, $structureBody);

            if ($result['parentToNextTree'] && $structureBody = $this->secondStructure($result['parentId'], $number)) {
                Operation::recordUpToNextTree($result['parentId'], $number, $structureBody);
            }
            return [
                'success' => true,
                'message' => null,
            ];
        } catch (\Exception $exception) {
            $message = sprintf('Ошибка %s', $exception->getFile() . ' / ' . $exception->getLine() . ' / ' . $exception->getMessage());
            return [
                'success' => false,
                'message' => $message,
            ];
        }

    }

    public function secondStructure($user_id, $number = 1)
    {
        $structureBody = $this->initStructureBody(BinaryStructure::SECOND_STRUCTURE, $number);

        $result = $this->setUserToTree($structureBody, $user_id);

        # TODO make correct this place
        if (!$result['success']) {
            return false;
        }
        $structureBody = $result['data'];
        $result = $this->checkParent($user_id, $structureBody);

        if ($result['parentToNextTree'] && $this->thirdStructure($result['parentId'], $number)) {
            Operation::recordUpToNextTree($result['parentId'], $number, $structureBody);
        }

        return $structureBody;
    }

    public function thirdStructure($user_id, $number = 1)
    {
        $structureBody = $this->initStructureBody(BinaryStructure::THIRD_STRUCTURE, $number);

        $result = $this->setUserToTree($structureBody, $user_id);

        if (!$result['success']) {
            return false;
        }
        $structureBody = $result['data'];
        $result = $this->checkParent($user_id, $structureBody);

        if ($result['parentToNextTree'] && $fourthStructureBody = $this->fourthStructure($result['parentId'], $number)) {
            Operation::recordUpToNextTree($result['parentId'], $number, $fourthStructureBody);
        }
        if ($result['parentToNextTree']) {
            $number = $number + 1;
            $resultFromInvestment = $this->firstStructure($result['parentId'], $number);
            if ($resultFromInvestment['success']) {
                Operation::recordReinvestment($result['parentId'], $number);
            }
        }

        return $structureBody;
    }

    public function fourthStructure($user_id, $number = 1)
    {
        $structureBody = $this->initStructureBody(BinaryStructure::FOURTH_STRUCTURE, $number);

        $result = $this->setUserToTree($structureBody, $user_id);
        if (!$result['success']) {
            return false;
        }
        $structureBody = $result['data'];
        $result = $this->checkParent($user_id, $structureBody);

        if ($result['parentToNextTree'] && $fifthStructureBody = $this->fifthStructure($result['parentId'], $number)) {
            Operation::recordUpToNextTree($result['parentId'], $number, $fifthStructureBody);
        }
        if ($result['parentToNextTree']) {
            $number = $number + 1;
            $resultFromInvestment = $this->firstStructure($result['parentId'], $number);
            if ($resultFromInvestment['success']) {
                Operation::recordReinvestment($result['parentId'], $number);
            }
        }

        return $structureBody;
    }

    public function fifthStructure($user_id, $number = 1)
    {
        $structureBody = $this->initStructureBody(BinaryStructure::FIFTH_STRUCTURE, $number);

        $result = $this->setUserToTree($structureBody, $user_id);


        if (!$result['success']) {
            return false;
        }
        $structureBody = $result['data'];

        return $structureBody;
    }

    public function initStructureBody($binaryStructureId, $number)
    {

        $structureBody = (new StructureBody)->getStructureBody($binaryStructureId, $number);

        // TODO check checkStructureBodyIsEmpty:  passed
        $BinaryStructureIsExist = StructureBody::checkStructureBodyIsExist($structureBody);


        // TODO check setRootUsersToStructureBody: passed
        if (!$BinaryStructureIsExist) {
            $structureBody = StructureBody::setRootUsersToStructureBody($binaryStructureId, $number);
        }

        return $structureBody;
    }

    public function checkParent($user_id, $structureBody)
    {
        // check parent has enough child to next tree
        // TODO check getTreeParentId
        $userPosition = StructureBody::getTreePositionByUserId($user_id, $structureBody);
        $treeParentPosition = (new StructureBody)->getTreeParentId($userPosition, $structureBody);

        $treeParentId = StructureBody::getIdByPosition($treeParentPosition, $structureBody);

        // TODO check parentHasEnoughChild passed to 70%;
        $checkParent = StructureBody::parentHasEnoughChild($treeParentPosition, $structureBody);

        return [
            'parentToNextTree' => $checkParent,
            'parentId' => $treeParentId,
        ];
    }


    public function setUserToTree($binaryStructureBody, $user_id)
    {
        $number = $binaryStructureBody->number;
        $tree = (new StructureBody)->getStructureBodyTreeRepresentation($binaryStructureBody);
        if ($number == 1) {
            $isUserExistInTree = in_array($user_id, $tree);
            $message = 'Такой пользователь уже существует в системе !';
        } else {
            $isUserExistInTree = in_array($user_id, $tree) && array_count_values($tree)[$user_id] >= 2;
            $message = 'Такой пользователь уже существует в системе дважды !';
        }


        if (!$isUserExistInTree) {
            $position = StructureBody::getPosition($binaryStructureBody, $user_id);

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
            $binaryStructureBody->tree_representation = json_encode($tree);
            $binaryStructureBody->save();
        } else {
            return [
                'success' => false,
                'message' => $message,
            ];
        }
        return [
            'success' => true,
            'message' => null,
            'data' => $binaryStructureBody,
        ];
    }


}
