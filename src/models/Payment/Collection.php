<?php

namespace App\Model\Payment;

use App\Model\Address;

class Collection
    implements \IteratorAggregate
{
    private $_methods;

    public function addPayment(IMethod $payment)
    {
        $this->_methods[] = $payment;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->_methods);
    }

    public function available(Address $address)
    {
        return array_filter(
            $this->_methods,
            function (IMethod $method) use ($address) {
                return $method->isAvailable($address);
            }
        );
    }
}
