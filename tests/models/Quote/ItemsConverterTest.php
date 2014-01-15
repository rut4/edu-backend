<?php

namespace Test\Model\Quote;


use App\Model\Address;
use App\Model\City;
use App\Model\Customer;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\Product;
use App\Model\Quote\AddressConverter;
use App\Model\Quote\DataConverter;
use App\Model\Quote\ItemsConverter;
use App\Model\Region;
use App\Model\Session;

class ItemsConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testConvertItemsPartToOrder()
    {
        $product = new Product(['name' => 'foo', 'sku' => 43, 'price' => 44]);

        $quoteItem = $this->getMock('\App\Model\QuoteItem', ['getProduct', 'getQuantity']);
        $quoteItem->expects($this->once())
            ->method('getProduct')
            ->will($this->returnValue($product));
        $quoteItem->expects($this->once())
            ->method('getQuantity')
            ->will($this->returnValue(1));

        $quote = $this->getMock('\App\Model\Quote', ['getItems']);
        $quote->expects($this->once())
            ->method('getItems')
            ->will($this->returnValue([$quoteItem]));

        $orderResource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $orderResource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('order_id'));


        $order = new \App\Model\Order(null, [], $orderResource);

        $orderItemResource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $orderItemResource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('order_item_id'));

        $orderItem = new \App\Model\OrderItem([], $orderItemResource);

        $session = $this->getMockBuilder('App\Model\Session', ['__construct'])
            ->disableOriginalConstructor()
            ->getMock();

        $itemsConverter = new ItemsConverter;

        $converterFactory = $this->getMock('\App\Model\Quote\ConverterFactory', ['getConverters']);
        $converterFactory->expects($this->once())
            ->method('getConverters')
            ->will($this->returnValue([$itemsConverter]));

        $converter = new \App\Model\Quote\Converter($converterFactory);

        $converter->toOrder($quote, $orderItem, $session, $order);
    }
}
