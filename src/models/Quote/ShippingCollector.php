<?php
namespace App\Model\Quote;

use App\Model\Quote;
use App\Model\Shipping\Factory;

class ShippingCollector
    implements ICollector
{
    public function collect(Quote $quote)
    {
        $methodCode = $quote->getShippingMethodCode();
        $method = (new Factory($quote->getAddress()))->getMethodByCode($methodCode);
        return $method->getPrice();
    }
}