<?php


namespace BX\Base\Abstractions;

use BX\Base\Interfaces\ManagerInterface;
use BX\Base\Interfaces\RepositoryInterface;
use BX\Log;

abstract class AbstractManager implements ManagerInterface
{
    protected Log $log;
    protected RepositoryInterface $repository;

    public function __construct()
    {
        $this->log = new Log('manager');
    }
}