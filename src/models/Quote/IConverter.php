<?php

namespace App\Model\Quote;

use App\Model\Order;
use App\Model\Quote;

interface IConverter
{
    public function toOrder(Quote $quote, Order $order);
}
