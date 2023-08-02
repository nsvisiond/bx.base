<?php

declare(strict_types=1);

namespace BX\Base\Repositories;

use Bitrix\Iblock\IblockTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Loader;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\UserTable;
use BX\Base\Abstractions\AbstractRepository;
use BX\Base\Abstractions\ModelCollection;
use BX\Base\Interfaces\ModelInterface;
use BX\Base\Models\IblockElementBaseModel;
use BX\Base\Models\UserModel;

Loader::includeModule('iblock');

class IblockElementBaseRepository extends AbstractRepository
{
    protected \BX\Log $log;
    protected string $iblockApiCode = '';
    protected string $iblockCode;
    protected int $iblockId;

    public function __construct()
    {
        $this->log = new \BX\Log();
        $this->setIblockIdAndCodeByApiCode();
    }

    protected function setIblockIdAndCodeByApiCode()
    {
        try {
            $iblock = IblockTable::getList([
                'filter' => [
                    'API_CODE' => $this->iblockApiCode
                ],
                'limit' => 1,
                'cache' => [
                    'ttl' => 86400000
                ],
                'select' => ['ID', 'CODE']
            ])->fetch();
            $this->iblockId = (int)$iblock['ID'];
            $this->iblockCode = (string)$iblock['CODE'];
        } catch (ObjectPropertyException|ArgumentException|SystemException $e) {
            $this->log->error($e->getMessage(), $e->getTrace());
        }
    }

    /**
     * @param int $id
     * @param array $params
     * @return \BX\Base\Interfaces\CollectionItemInterface|null
     */
    public function getById(int $id, array $params = []): ?ModelInterface
    {
        $baseParams = [
            'filter' => [
                '=ID' => $id
            ],
            'limit' => 1,
        ];

        $params = array_merge($baseParams, $params);

        try {
            $fileList = $this->getList($params);
            return $fileList->first();
        } catch (ObjectPropertyException|ArgumentException|SystemException $e) {
            $this->log->error($e->getMessage(), $e->getTrace());
        }

        return null;
    }

    /**
     * @param array $params
     * @return \BX\Base\Abstractions\ModelCollection
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function getList(array $params): ModelCollection
    {
        if (empty($params['select'])) {
            $params['select'] = [
                '*'
            ];
            $props = \CIBlockProperty::GetList(['SORT' => 'ASC'], [
                'IBLOCK_CODE' => $this->iblockCode,
                'ACTIVE' => 'Y'
            ]);
            while ($prop = $props->Fetch()) {
                if ($prop['CODE'] !== 'IBLOCK_ID') {
                    $params['select'][$prop['CODE'] . '_VALUE'] = $prop['CODE'] . '.VALUE';
                }
            }
        }
        $params['filter']['=IBLOCK_ID'] = $this->iblockId;
        $iblockElementClass = '\Bitrix\Iblock\Elements\Element' . ucfirst($this->iblockApiCode) . 'Table';
        $iblockElementsList = $iblockElementClass::getList($params)->fetchAll();
        $modelClass = str_replace(['Repository', 'Repositories', 'Application'], ['Model', 'Models', 'Domain'], get_called_class());

        return new ModelCollection($iblockElementsList, $modelClass);
    }

    public function getActiveList(): ModelCollection
    {
        return $this->getList([
            'filter' => [
                'ACTIVE' => 'Y'
            ]
        ]);
    }


}
