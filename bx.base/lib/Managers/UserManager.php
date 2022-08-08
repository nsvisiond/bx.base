<?php


namespace BX\Base\Managers;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Error;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\PhoneNumber\Format;
use Bitrix\Main\PhoneNumber\Parser;
use Bitrix\Main\Result;
use Bitrix\Main\SystemException;
use BX\Base\Abstractions\AbstractManager;
use BX\Base\Interfaces\ModelInterface;
use BX\Base\Models\UserModel;
use BX\Base\Repositories\UserRepository;
use CUser;

class UserManager extends AbstractManager
{
    public function __construct()
    {
        $this->repository = new UserRepository();
    }


    /**
     * @param UserModel $model
     * @return Result
     */
    public function save(ModelInterface $model): Result
    {
        $data = current((array)$model);
        return $this->update($model, $data);
    }

    /**
     * @param UserModel $user
     * @param array $data
     * @return void
     */
    public function update(ModelInterface $user, array $data): Result
    {
        foreach ($data as $key => $value) {
            if (!$user->hasValueKey($key)) {
                unset($data[$key]);
            }
        }

        return $this->updateWithNulls($user, $data);
    }

    /**
     * @param UserModel $model
     * @param array $data
     * @return Result
     */
    public function updateWithNulls(ModelInterface $model, array $data): Result
    {
        $data = $this->processFields($data);

        $result = new Result();
        $cUser = new CUser();

        if ($model->getId() > 0) {
            $isSuccess = (bool)$cUser->Update($model->getId(), $data);

            if (!$isSuccess) {
                return $result->addError(new Error("Ошибка обновления пользователя: {$cUser->LAST_ERROR}"));
            }

            return $result;
        }

        $id = (int)$cUser->Add($data);
        if (!$id) {
            return $result->addError(new Error("Ошибка добавления пользователя: {$cUser->LAST_ERROR}"));
        }

        $model['ID'] = $id;

        return $result;
    }

    /**
     * @param int $id
     * @return Result
     */
    public function delete(int $id): Result
    {
        $result = new Result();
        try {
            $file = $this->repository->getById($id);
        } catch (ObjectPropertyException|ArgumentException|SystemException $e) {
            $file = null;
        }
        if (empty($file)) {
            return $result->addError(new Error('Пользователь не найден', 404));
        }

        $isSuccess = CUser::Delete($id);
        if (!$isSuccess) {
            return $result->addError(new Error('Ошибка удаления пользователя', 500));
        }

        return $result;
    }

    private function processFields(array $data): array
    {
        if ((int)$data['PERSONAL_PHOTO'] > 0) {
            unset($data['PERSONAL_PHOTO']);
        }

        $parsedPhone = Parser::getInstance()->parse($data['PHONE_NUMBER']);
        if (strpos($data['PHONE_NUMBER'], '+') === false) {
            $data['PHONE_NUMBER'] = '+'.$parsedPhone->format(Format::NATIONAL);
        }

        return $data;
    }

}
