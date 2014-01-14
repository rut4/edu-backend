<?php

namespace Test\Model\Quote;


use App\Model\Address;
use App\Model\City;
use App\Model\Customer;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\Quote\AddressConverter;
use App\Model\Quote\DataConverter;
use App\Model\Region;
use App\Model\Session;

class DataConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testConvertDataPartToOrder()
    {
        $customer = new Customer(['customer_id' => 42]);

        $quote = $this->getMock('\App\Model\Quote',
            ['getShippingMethodCode', 'getPaymentMethodCode', 'getSubtotal', 'getShipping', 'getGrandTotal']);
        $quote->expects($this->once())
            ->method('getShippingMethodCode')
            ->will($this->returnValue('foo'));
        $quote->expects($this->once())
            ->method('getPaymentMethodCode')
            ->will($this->returnValue('bar'));
        $quote->expects($this->once())
            ->method('getSubtotal')
            ->will($this->returnValue(43));
        $quote->expects($this->once())
            ->method('getShipping')
            ->will($this->returnValue(44));
        $quote->expects($this->once())
            ->method('getGrandTotal')
            ->will($this->returnValue(43 + 44));

        $order = new \App\Model\Order;
        $orderItem = new \App\Model\OrderItem;

        $session = $this->getMockBuilder('App\Model\Session', ['__construct', 'getCustomer'])
            ->disableOriginalConstructor()
            ->getMock();

        $session->expects($this->once())
            ->method('getCustomer')
            ->will($this->returnValue($customer));

        $dataConverter = new DataConverter;

        $converterFactory = $this->getMock('\App\Model\Quote\ConverterFactory', ['getConverters']);
        $converterFactory->expects($this->once())
            ->method('getConverters')
            ->will($this->returnValue([$dataConverter]));

        $converter = new \App\Model\Quote\Converter($converterFactory);

        $converter->toOrder($quote, $orderItem, $session, $order);

        $expectedOrder = new Order();
        $expectedOrder->setOrderData([
            'customer_id' => 42,
            'shipping_method_code' => 'foo',
            'payment_method_code' => 'bar',
            'subtotal' => 43,
            'shipping' => 44,
            'grand_total' => 43 + 44
        ]);

        $this->assertEquals($expectedOrder, $order);
    }
}
