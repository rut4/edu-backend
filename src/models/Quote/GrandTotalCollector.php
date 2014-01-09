<?php
namespace App\Model\Quote;

use App\Model\Quote;

class GrandTotalCollector
    implements ICollector
{
    public function collect(Quote $quote)
    {
        return $quote->getShipping() + $quote->getSubtotal();
    }
}