<?php
namespace Test\Model\Payment;


use App\Model\Payment\Collection;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testIsIterableWithForeachFunction()
    {

        $collection = new Collection;
        $expected = [
            $this->getMock('\App\Model\Payment\IMethod'),
            $this->getMock('\App\Model\Payment\IMethod')
        ];
        $collection->addPayment($expected[0]);
        $collection->addPayment($expected[1]);
        $iterated = false;

        foreach ($collection as $_key => $_payment) {
            $this->assertSame($expected[$_key], $_payment);
            $iterated = true;
        }

        if (!$iterated) {
            $this->fail('Iteration did not happen');
        }
    }
} 