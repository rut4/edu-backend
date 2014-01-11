<?php

namespace App\Model\Quote;

use App\Model\OrderItem;
use App\Model\Session;
use App\Model\Order;
use App\Model\Quote;

interface IConverter
{
    public function toOrder(Quote $quote, OrderItem $orderItem, Session $session, Order $order);
}
