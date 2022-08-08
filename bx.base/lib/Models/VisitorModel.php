<?php


namespace BX\Base\Models;

use BX\Base\Abstractions\AbstractModel;

class VisitorModel extends AbstractModel
{
    public function getIp(): string
    {
        return $this['SESS_IP'];
    }

    public function getField(string $key)
    {
        return $this['BX_VISITOR_'.$key];
    }

    public function setField(string $key, $value): VisitorModel
    {
        $this['BX_VISITOR_'.$key] = $value;
        return $this;
    }
}