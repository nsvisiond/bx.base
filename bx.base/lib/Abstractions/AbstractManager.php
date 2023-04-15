<?php


namespace BX\Base\Abstractions;

use BX\Base\Interfaces\ManagerInterface;
use BX\Base\Interfaces\RepositoryInterface;

abstract class AbstractManager implements ManagerInterface
{
    protected RepositoryInterface $repository;
}