<?php
namespace App\Model\Payment;


class Factory
{
    private $_collection;

    public function __construct(Collection $collection)
    {
        $this->_collection = $collection;
    }

    public function getMethods()
    {
        foreach ($this->_getMethods() as $method) {
            $this->_collection->addPayment($method);
        }
        return $this->_collection;
    }

    private function _getMethods()
    {
        return [
            new Courier,
            new CashOnDelivery
        ];
    }
} 