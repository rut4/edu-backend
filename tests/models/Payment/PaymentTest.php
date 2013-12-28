<?php

namespace Test\Model\Payment;


class PaymentTest extends \PHPUnit_Framework_TestCase
{

    public function testReturnsPaymentMethodsInstances()
    {
        $collection = $this->getMock('\App\Model\Payment\Collection', ['addPayment']);
        $factory = new \App\Model\Payment\Factory($collection);

        $collection->expects($this->at(0))
            ->method('addPayment')
            ->with($this->isInstanceOf('\App\Model\Payment\Courier'));
        $collection->expects($this->at(1))
            ->method('addPayment')
            ->with($this->isInstanceOf('\App\Model\Payment\CashOnDelivery'));
        $this->assertSame($collection, $factory->getMethods());

    }
}

