<?php

namespace App\Model\Quote;


use App\Model\Quote;

interface ICollector
{
    public function collect(Quote $quote);
}
