<?php

namespace App\Model\Quote;

use App\Model\Quote;
use App\Model\Product;

class SubtotalCollector
    implements ICollector
{
    private $_product;

    public function __construct(Product $product)
    {
        $this->_product = $product;
    }

    public function collect(Quote $quote)
    {
        $productTotal = 0;

        foreach ($quote->getItems() as $_quoteItem) {
            $quantity = $_quoteItem->getQuantity();
            $this->_product->load($_quoteItem->getProductId());

            $productCost = $this->_product->isSpecialPriceApplied() ?
                $this->_product->getSpecialPrice() : $this->_product->getPrice();

            $productTotal += $productCost * $quantity;
        }

        return $productTotal;
    }
}