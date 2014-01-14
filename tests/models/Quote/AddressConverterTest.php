<?php

namespace Test\Model\Quote;


use App\Model\Address;
use App\Model\City;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\Quote\AddressConverter;
use App\Model\Region;
use App\Model\Session;

class AddressConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testConverterAddressPartToOrder()
    {
        $city = new City(['name' => 'bar']);
        $region = new Region(['name' => 'baz']);
        $address = new Address([
            'postal_code' => 42,
            'street' => 'foo',
            'home_number' => 43,
            'flat' => 44
        ], null, $region, $city);

        $quote = $this->getMock('\App\Model\Quote', ['getAddress']);
        $quote->expects($this->once())
            ->method('getAddress')
            ->will($this->returnValue($address));

        $order = new \App\Model\Order;
        $orderItem = new \App\Model\OrderItem;
        $session = $this->getMockBuilder('App\Model\Session', ['__construct'])
            ->disableOriginalConstructor()
            ->getMock();

        $addressConverter = new AddressConverter;

        $converterFactory = $this->getMock('\App\Model\Quote\ConverterFactory', ['getConverters']);
        $converterFactory->expects($this->once())
            ->method('getConverters')
            ->will($this->returnValue([$addressConverter]));

        $converter = new \App\Model\Quote\Converter($converterFactory);

        $converter->toOrder($quote, new OrderItem, $session, $order);

        $expectedOrder = new Order();
        $expectedOrder->setOrderData([
            'region_name' => 'baz',
            'city_name' => 'bar',
            'postal_code' => 42,
            'street' => 'foo',
            'home_number' => 43,
            'flat' => 44
        ]);

        $this->assertEquals($expectedOrder, $order);
    }
}
