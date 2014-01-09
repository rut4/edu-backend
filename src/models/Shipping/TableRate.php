<?php

namespace App\Model\Shipping;

use App\Model\Address;
use App\Model\Resource\IResourceEntity;
use App\Model\City;

class TableRate implements IMethod
{
    private $_code = 'table_rate';
    private $_address;
    private $_priceTable = [
        1 => 12,
        2 => 9,
        3 => 34.5,
        4 => 50
    ];

    public function __construct(Address $address)
    {
        $this->_address = $address;
    }

    public function getPrice()
    {
        return $this->_priceTable[$this->_address->getCityId()];
    }

    public function getCode()
    {
        return $this->_code;
    }
}
