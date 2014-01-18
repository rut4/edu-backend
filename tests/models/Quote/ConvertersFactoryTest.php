<?php

namespace Test\Model\Quote;


use App\Model\Product;
use App\Model\Quote\AddressConverter;
use App\Model\Quote\CollectorsFactory;
use App\Model\Quote\ConverterFactory;
use App\Model\Quote\DataConverter;
use App\Model\Quote\GrandTotalCollector;
use App\Model\Quote\ItemsConverter;
use App\Model\Quote\ShippingCollector;
use App\Model\Quote\SubtotalCollector;

class ConverterFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactoryReturnsCollectors()
    {
        $factory = new ConverterFactory;
        
        $expectedCollectors = [
            new DataConverter,
            new AddressConverter,
            new ItemsConverter
        ];

        $this->assertEquals($expectedCollectors, $factory->getConverters());
    }
}
