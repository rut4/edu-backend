<?php

namespace App\Model\Shipping;

use App\Model\Address;
use App\Model\Resource\IResourceEntity;
use App\Model\City;

class TableRate implements IMethod
{
    private $_code = 'table_rate';
    private $_address;
    private $_cityResource;

    public function __construct(Address $address, IResourceEntity $cityResource)
    {
        $this->_address = $address;
        $this->_cityResource = $cityResource;
    }

    public function getPrice()
    {
        $city = new City($this->_address->getCity($this->_cityResource));
        return $city->getPrice() ? $city->getPrice() : 'none';
    }

    public function getCode()
    {
        return $this->_code;
    }
}
