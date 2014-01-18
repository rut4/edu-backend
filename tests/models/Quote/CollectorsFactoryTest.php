<?php

namespace Test\Model\Quote;


use App\Model\Product;
use App\Model\Quote\CollectorsFactory;
use App\Model\Quote\GrandTotalCollector;
use App\Model\Quote\ShippingCollector;
use App\Model\Quote\SubtotalCollector;

class CollectorsFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactoryReturnsCollectors()
    {
        $product = new Product(['product_id' => 1]);
        $factory = new CollectorsFactory($product);

        $expectedCollectors = [
            'subtotal' => new SubtotalCollector($product),
            'shipping' => new ShippingCollector,
            'grand_total' => new GrandTotalCollector
        ];

        $this->assertEquals($expectedCollectors, $factory->getCollectors());
    }
}
