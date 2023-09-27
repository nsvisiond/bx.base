<?php

namespace BX\Base\Models;

use Bitrix\Main\Error;
use Bitrix\Main\Loader;
use Bitrix\Main\Result;
use BX\Base\Abstractions\AbstractModel;
use CIBlockSection;

Loader::includeModule('highloadblock');

class HlBlockBaseModel extends AbstractModel
{
    public function save(): Result
    {
        $result = new Result();
        $section = new CIBlockSection();

        $id = $this->getId();
        $data = $this->toArray();

        if ($id > 0) {
            unset($data['ID']);
            $isSuccess = (bool)$section->Update($id, $data);

            if (!$isSuccess) {
                return $result->addError(new Error("Ошибка обновления раздела инфоблока: {$section->LAST_ERROR}"));
            }

            return $result;
        }

        $id = (int)$section->Add($data);
        if (!$id) {
            return $result->addError(new Error("Ошибка добавления раздела инфоблока: {$section->LAST_ERROR}"));
        }

        return $result;
    }
}
