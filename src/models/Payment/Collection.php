<?php

namespace App\Model\Payment;


class Collection implements \IteratorAggregate
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
}
