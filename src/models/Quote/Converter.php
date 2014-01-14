<?php

namespace App\Model\Quote;

use App\Model\Order;
use App\Model\OrderItem;
use App\Model\Quote;
use App\Model\Session;

class Converter
{
    private $_converterFactory;

    public function __construct(Quote\ConverterFactory $converterFactory)
    {
        $this->_converterFactory = $converterFactory;
    }
    public function toOrder(Quote $quote, OrderItem $orderItem, Session $session, Order $order)
    {
        foreach ($this->_converterFactory->getConverters() as $converter) {
            $converter->toOrder($quote, $orderItem, $session, $order);
        }
    }
}
