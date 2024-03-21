<?php


namespace BX\Base\Abstractions;

use BX\Base\Interfaces\ManagerInterface;
use BX\Base\Interfaces\RepositoryInterface;
use App\Log;
use BX\Base\Interfaces\ServiceInterface;

abstract class AbstractService implements ServiceInterface
{
    protected Log $log;
    protected RepositoryInterface $repository;
    protected ManagerInterface $manager;

    public function __construct()
    {
        $this->log = new Log('service');
    }
}
