<?php


namespace BX\Base\Repositories;

use BX\Log;
use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\Model\Section;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use BX\Base\Abstractions\AbstractRepository;
use BX\Base\Abstractions\ModelCollection;
use BX\Base\Interfaces\ModelInterface;

class IblockSectionBaseRepository extends AbstractRepository
{
    protected Log $log;
    protected string $iblockApiCode;
    protected string $iblockCode;
    protected int $iblockId;

    public function __construct()
    {
        $this->log = new Log();
        $this->setIblockId();
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
     * @param int $code
     * @param array $params
     * @return \BX\Base\Interfaces\CollectionItemInterface|null
     */
    public function getByCode(string $code, array $params = []): ?ModelInterface
    {
        $baseParams = [
            'filter' => [
                '=CODE' => $code
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

    public function getList(array $params): ModelCollection
    {
        if (empty($params['select'])) {
            $params['select'] = [
                '*'
            ];
        }

        $sectionEntity = Section::compileEntityByIblock($this->iblockId);
        $section = [];
        try {
            $params['filter']['=IBLOCK_ID'] = $this->iblockId;
            $section = $sectionEntity::getList($params)->fetchAll();
        } catch (ObjectPropertyException|ArgumentException|SystemException $e) {
            $this->log->error($e->getMessage(), $e->getTrace());
        }

        $modelClass = str_replace(['Repository', 'Repositories'], ['Model', 'Models'], get_called_class());
        if (!class_exists($modelClass)) {
            $modelClass = str_replace(['Repository', 'Repositories'], ['', 'Models'], get_called_class());
        }

        return new ModelCollection($section, $modelClass);
    }

    protected function setIblockId()
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
                'select' => ['ID']
            ])->fetch();
            $this->iblockId = (int)$iblock['ID'];
        } catch (ObjectPropertyException|ArgumentException|SystemException $e) {
            $this->log->error($e->getMessage(), $e->getTrace());
        }
    }
}
