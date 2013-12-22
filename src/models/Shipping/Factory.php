<?php

namespace App\Model\Shipping;

use App\Model\Resource\IResourceEntity;

class Factory
{
    private $_address;
    private $_cityResource;

    public function __construct(\App\Model\Address $address, IResourceEntity $cityResource)
    {
        $this->_address = $address;
        $this->_cityResource = $cityResource;
    }

    public function getMethods()
    {
        return [
            new Fixed($this->_address),
            new TableRate($this->_address, $this->_cityResource)
        ];
    }
}

