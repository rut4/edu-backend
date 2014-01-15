<?php

namespace Test\Model\Quote;


use App\Model\Address;
use App\Model\OrderItem;
use App\Model\Product;
use App\Model\Quote\GrandTotalCollector;
use App\Model\Quote\ShippingCollector;
use App\Model\Quote\SubtotalCollector;
use App\Model\QuoteItem;
use App\Model\Session;

class SubtotalCollectorTest extends \PHPUnit_Framework_TestCase
{
    public function testCalculateSubtotal()
    {
        $product = $this->getMock('\App\Model\Product', ['load', 'isSpecialPriceApplied', 'getSpecialPrice', 'getPrice']);

        $product->expects($this->at(0))
            ->method('load')
            ->with($this->equalTo(2));
        $product->expects($this->at(1))
            ->method('isSpecialPriceApplied')
            ->will($this->returnValue(true));
        $product->expects($this->at(2))
            ->method('getSpecialPrice')
            ->will($this->returnValue(42));

        $product->expects($this->at(3))
            ->method('load')
            ->with($this->equalTo(8));
        $product->expects($this->at(4))
            ->method('isSpecialPriceApplied')
            ->will($this->returnValue(false));
        $product->expects($this->at(5))
            ->method('getPrice')
            ->will($this->returnValue(43));

        $quote = $this->getMock('\App\Model\Quote', ['getItems', 'getAddress']);
        $quote->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue([
                new QuoteItem(['quantity' => 1, 'product_id' => 2]),
                new QuoteItem(['quantity' => 4, 'product_id' => 8]),
            ]));

        $subtotalCollection = new SubtotalCollector($product);
        $this->assertEquals(42 + 43 * 4, $subtotalCollection->collect($quote));
    }
}
