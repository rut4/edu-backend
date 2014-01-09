<?php

namespace App\Model\Payment;

use App\Model\Address;

class Courier implements IMethod
{

    public function getCode()
    {
        return 'courier';
    }

    public function isAvailable(Address $address)
    {
        return $address->getCityId() === 1;
    }

    public function getLabel()
    {
        return 'Courier';
    }
}
