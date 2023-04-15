<?php

namespace BX\Base\Interfaces;

use Bitrix\Main\Result;

interface ManagerInterface
{
    public function create(ModelInterface $model): Result;
    public function update(ModelInterface $model): Result;
    public function delete(int $id): Result;
}