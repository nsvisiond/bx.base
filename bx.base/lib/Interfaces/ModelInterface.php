<?php

namespace BX\Base\Interfaces;

use ArrayAccess;
use IteratorAggregate;

interface ModelInterface extends ArrayAccess, IteratorAggregate, CollectionItemInterface, MappableInterface
{
    /**
     * @return array
     */
    public function getApiModel(): array;
}
