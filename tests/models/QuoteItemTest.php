<?php

namespace Test\Model;

use App\Model\QuoteItem;

class QuoteItemTest
    extends \PHPUnit_Framework_TestCase
{
    public function testReturnsIdWhichHasBeenInitialized()
    {
        $quoteItem = new QuoteItem(['quote_item_id' => 123123123]);
        $this->assertEquals(123123123, $quoteItem->getId());

        $quoteItem = new QuoteItem(['quote_item_id' => 1]);
        $this->assertEquals(1, $quoteItem->getId());
    }


    public function testReturnsProductIdWhichHasBeenInitialized()
    {
        $quoteItem = new QuoteItem(['product_id' => 123123123]);
        $this->assertEquals(123123123, $quoteItem->getProductId());

        $quoteItem = new QuoteItem(['product_id' => 1]);
        $this->assertEquals(1, $quoteItem->getProductId());
    }

    public function testReturnsCustomerIdWhichHasBeenInitialized()
    {
        $quoteItem = new QuoteItem(['customer_id' => 123123123]);
        $this->assertEquals(123123123, $quoteItem->getCustomerId());

        $quoteItem = new QuoteItem(['customer_id' => 1]);
        $this->assertEquals(1, $quoteItem->getCustomerId());
    }

    public function testReturnsQuantityWhichHasBeenInitialized()
    {
        $quoteItem = new QuoteItem(['quantity' => 123123123]);
        $this->assertEquals(123123123, $quoteItem->getQuantity());

        $quoteItem = new QuoteItem(['quantity' => 1]);
        $this->assertEquals(1, $quoteItem->getQuantity());
    }

    public function testAddQuantityInQuoteItem()
    {
        $quoteItem = new QuoteItem(['quantity' => 1]);
        $quoteItem->addQuantity(1);
        $this->assertEquals(2, $quoteItem->getQuantity());
    }

    public function testDeleteQuantityInQuoteItem()
    {
        $quoteItem = new QuoteItem(['quantity' => 1]);
        $quoteItem->deleteQuantity(1);
        $this->assertEquals(0, $quoteItem->getQuantity());
    }

    public function testUpdateQuantityInQuoteItem()
    {
        $quoteItem = new QuoteItem(['quantity' => 1]);
        $quoteItem->updateQuantity(3);
        $this->assertEquals(3, $quoteItem->getQuantity());
    }

} 