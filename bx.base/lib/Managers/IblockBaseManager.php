<?php


namespace BX\Base\Managers;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Error;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\Result;
use Bitrix\Main\SystemException;
use BX\Base\Abstractions\AbstractManager;
use CIBlockElement;
use CIBlockSection;
use Exception;
use Rpn\Main\Repositories\RegionalContentElementRepository;
use Rpn\Main\Repositories\RegionalContentSectionRepository;

class IblockBaseManager extends AbstractManager
{
    /**
     * @var \Rpn\Main\Repositories\RegionalContentElementRepository
     */
    protected RegionalContentElementRepository $elementRepository;
    /**
     * @var \Rpn\Main\Repositories\RegionalContentSectionRepository
     */
    protected RegionalContentSectionRepository $sectionRepository;

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
}
