<?php

namespace Test\Model\Shipping;

class FixedTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsPrice ()
    {
        $fixed = new \App\Model\Shipping\Fixed;
        $this->assertEquals(42, $fixed->getPrice());

    }
} 