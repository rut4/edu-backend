<?php

namespace Test\Model\Quote;


use App\Model\Address;
use App\Model\OrderItem;
use App\Model\Quote\GrandTotalCollector;
use App\Model\Quote\ShippingCollector;
use App\Model\Session;

class ShippingCollectorTest extends \PHPUnit_Framework_TestCase
{
    public function testCalculateShipping()
    {
        $quote = $this->getMock('\App\Model\Quote', ['getShippingMethodCode', 'getAddress']);
        $quote->expects($this->at(0))
            ->method('getShippingMethodCode')
            ->will($this->returnValue('table_rate'));
        $quote->expects($this->at(1))
            ->method('getAddress')
            ->will($this->returnValue(new Address(['city_id' => 1])));

        $grandTotalCollection = new ShippingCollector;
        $this->assertEquals(12, $grandTotalCollection->collect($quote));
    }
}
