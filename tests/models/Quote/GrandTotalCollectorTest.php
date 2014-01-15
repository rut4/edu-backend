<?php

namespace Test\Model\Quote;


use App\Model\OrderItem;
use App\Model\Quote\GrandTotalCollector;
use App\Model\Session;

class GrandTotalCollectorTest extends \PHPUnit_Framework_TestCase
{
    public function testCalculateGrandTotal()
    {
        $quote = $this->getMock('\App\Model\Quote', ['getShipping', 'getSubtotal']);
        $quote->expects($this->at(0))
            ->method('getShipping')
            ->will($this->returnValue(42));
        $quote->expects($this->at(1))
            ->method('getSubtotal')
            ->will($this->returnValue(43));

        $grandTotalCollection = new GrandTotalCollector();
        $this->assertEquals(42 + 43, $grandTotalCollection->collect($quote));
    }
}
