<?php

namespace App\Model\Shipping;

interface IMethod
{
    public function getPrice();

    public function getCode();
}
