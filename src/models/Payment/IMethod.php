<?php

namespace App\Model\Payment;

use App\Model\Address;

interface IMethod
{
    public function getCode();

    public function isAvailable(Address $address);

    public function getLabel();
}
