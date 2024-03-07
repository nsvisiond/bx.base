<?php


namespace BX\Base\Managers;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Error;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\Result;
use Bitrix\Main\SystemException;
use BX\Base\Abstractions\AbstractManager;
use BX\Base\Abstractions\AbstractRepository;
use BX\Base\Interfaces\RepositoryInterface;
use CIBlockElement;
use CIBlockSection;
use Exception;
use OG\Main\Repositories\RegionalContentElementRepository;
use OG\Main\Repositories\RegionalContentSectionRepository;
use BX\Base\Interfaces\ModelInterface;

class IblockBaseManager extends AbstractManager
{
    /**
     * @var \OG\Main\Repositories\RegionalContentElementRepository
     */
    protected AbstractRepository $elementRepository;
    /**
     * @var \OG\Main\Repositories\RegionalContentSectionRepository
     */
    protected RepositoryInterface $sectionRepository;

    public function deleteElement(int $id): Result
    {
        $result = new Result();
        try {
            $element = $this->elementRepository->getById($id);
        } catch (ObjectPropertyException|ArgumentException|SystemException|Exception $e) {
            $element = null;
        }
        if (empty($element)) {
            return $result->addError(new Error('Элемент не найден', 404));
        }

        $isSuccess = CIBlockElement::Delete($id);
        if (!$isSuccess) {
            return $result->addError(new Error('Ошибка удаления элемента с ID=' . $id, 500));
        }

        return $result;
    }

    public function delete(int $id): Result
    {
        $result = new Result();

        return $result->addError(new Error('Use deleteElement() and deleteSection() methods for Iblock', 404));
    }

    public function deleteSection(int $id): Result
    {
        $result = new Result();
        try {
            $element = $this->sectionRepository->getById($id);
        } catch (ObjectPropertyException|ArgumentException|SystemException|Exception $e) {
            $element = null;
        }
        if (empty($element)) {
            return $result->addError(new Error('Раздел не найден', 404));
        }

        $isSuccess = CIBlockSection::Delete($id);
        if (!$isSuccess) {
            return $result->addError(new Error('Ошибка удаления раздела с ID=' . $id, 500));
        }

        return $result;
    }

    public function save(ModelInterface $model): Result
    {
        return $model->save();
    }
}
