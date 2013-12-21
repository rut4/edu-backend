<?php

namespace Test\Model\Shipping;

use App\Model\Address;
use App\Model\Shipping\Factory;

class FactoryTest
    extends \PHPUnit_Framework_TestCase
{
    public function testReturnsShippingMethodsInstances()
    {
        $address = new Address;
        $factory = new Factory($address);
        $methods = $factory->getMethods();
        $classes = array_map(function ($method) {
            return get_class($method);
        }, $methods);

        $this->assertEquals([
            'App\Model\Shipping\Fixed',
            'App\Model\Shipping\TableRate'
        ], $classes);
    }
}
