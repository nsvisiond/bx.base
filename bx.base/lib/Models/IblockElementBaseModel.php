<?php

namespace BX\Base\Models;

use Bitrix\Main\Error;
use Bitrix\Main\Loader;
use Bitrix\Main\Result;
use Bitrix\Main\Type\DateTime;
use BX\Base\Abstractions\AbstractModel;

Loader::includeModule('iblock');

class IblockElementBaseModel extends AbstractModel
{
    /**
     * @param int $value
     * @return void
     */
    public function setId(int $value)
    {
        $this['ID'] = $value;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setName(string $value)
    {
        $this['NAME'] = $value;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setActive(string $value)
    {
        $this['ACTIVE'] = $value;
    }

    /**
     * @param int $value
     * @return void
     */
    public function setIblockId(int $value)
    {
        $this['IBLOCK_ID'] = $value;
    }

    /**
     * @param DateTime $value
     * @return void
     */
    public function setDateCreate(DateTime $value)
    {
        $this['DATE_CREATE'] = $value;
    }

    /**
     * @param DateTime $value
     * @return void
     */
    public function setActiveFrom(DateTime $value)
    {
        $this['ACTIVE_FROM'] = $value;
    }

    /**
     * @param DateTime $value
     * @return void
     */
    public function setActiveTo(DateTime $value)
    {
        $this['ACTIVE_TO'] = $value;
    }

    /**
     * @param int $value
     * @return void
     */
    public function setSort(int $value)
    {
        $this['SORT'] = $value;
    }

    /**
     * @param int $value
     * @return void
     */
    public function setPreviewPicture(int $value)
    {
        $this['PREVIEW_PICTURE'] = $value;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setPreviewText(string $value)
    {
        $this['PREVIEW_TEXT'] = $value;
    }

    /**
     * @param int $value
     * @return void
     */
    public function setDetailPicture(int $value)
    {
        $this['DETAIL_PICTURE'] = $value;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setDetailText(string $value)
    {
        $this['DETAIL_TEXT'] = $value;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setCode(string $value)
    {
        $this['CODE'] = $value;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setTags(string $value)
    {
        $this['TAGS'] = $value;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setIblockSectionId(string $value)
    {
        $this['IBLOCK_SECTION_ID'] = $value;
    }

    /**
     * @param DateTime $value
     * @return void
     */
    public function setTimestampX(DateTime $value)
    {
        $this['TIMESTAMP_X'] = $value;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'NAME' => $this->getName(),
            'ACTIVE' => $this->getActive(),
            'IBLOCK_ID' => $this->getIblockId(),
            'DATE_CREATE' => $this->getDateCreate(),
            'ACTIVE_FROM' => $this->getActiveFrom(),
            'ACTIVE_TO' => $this->getActiveTo(),
            'SORT' => $this->getSort(),
            'PREVIEW_PICTURE' => $this->getPreviewPicture(),
            'PREVIEW_TEXT' => $this->getPreviewText(),
            'DETAIL_PICTURE' => $this->getDetailPicture(),
            'DETAIL_TEXT' => $this->getDetailText(),
            'CODE' => $this->getCode(),
            'TAGS' => $this->getTags(),
            'IBLOCK_SECTION_ID' => $this->getIblockSectionId(),
            'TIMESTAMP_X' => $this->getTimestampX(),
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return (int)$this['ID'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return (string)$this['NAME'];
    }

    /**
     * @return string
     */
    public function getActive(): string
    {
        return (string)$this['ACTIVE'];
    }

    /**
     * @return int
     */
    public function getIblockId(): int
    {
        return (int)$this['IBLOCK_ID'];
    }

    /**
     * @return ?DateTime
     */
    public function getDateCreate(): ?DateTime
    {
        return $this['DATE_CREATE'] instanceof DateTime ? $this['DATE_CREATE'] : null;
    }

    /**
     * @return ?DateTime
     */
    public function getActiveFrom(): ?DateTime
    {
        return $this['ACTIVE_FROM'] instanceof DateTime ? $this['ACTIVE_FROM'] : null;
    }

    /**
     * @return ?DateTime
     */
    public function getActiveTo(): ?DateTime
    {
        return $this['ACTIVE_TO'] instanceof DateTime ? $this['ACTIVE_TO'] : null;
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return (int)$this['SORT'];
    }

    /**
     * @return int
     */
    public function getPreviewPicture(): int
    {
        return (int)$this['PREVIEW_PICTURE'];
    }

    /**
     * @return string
     */
    public function getPreviewText(): string
    {
        return (string)$this['PREVIEW_TEXT'];
    }

    /**
     * @return int
     */
    public function getDetailPicture(): int
    {
        return (int)$this['DETAIL_PICTURE'];
    }

    /**
     * @return string
     */
    public function getDetailText(): string
    {
        return (string)$this['DETAIL_TEXT'];
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return (string)$this['CODE'];
    }

    /**
     * @return string
     */
    public function getTags(): string
    {
        return (string)$this['TAGS'];
    }

    /**
     * @return string
     */
    public function getIblockSectionId(): string
    {
        return (string)$this['IBLOCK_SECTION_ID'];
    }

    /**
     * @return ?DateTime
     */
    public function getTimestampX(): ?DateTime
    {
        return $this['TIMESTAMP_X'] instanceof DateTime ? $this['TIMESTAMP_X'] : null;
    }

    public function save(): Result
    {
        $result = new Result();
        $element = new \CIBlockElement();

        $id = $this->getId();
        $data = $this->toArray();

        if ($id > 0) {
            unset($data['ID']);
            $isSuccess = (bool)$element->Update($id, $data);

            if (!$isSuccess) {
                return $result->addError(new Error("Ошибка обновления элемента инфоблока: {$element->LAST_ERROR}"));
            }

            return $result;
        }

        $id = (int)$element->Add($data);
        if (!$id) {
            return $result->addError(new Error("Ошибка добавления элемента инфоблока: {$element->LAST_ERROR}"));
        }

        return $result;
    }
}
