<?php

namespace Test\Model;

use App\Model\Customer;
use App\Model\Product;
use App\Model\Quote;
use App\Model\QuoteItem;
use App\Model\Session;

class QuoteTest
    extends \PHPUnit_Framework_TestCase
{

    public function testAppliedChoiceAsToIdentifyUser()
    {
        $customer = new Customer(['customer_id', 1]);
        $quote = new Quote;
        $quote->loadByCustomer($customer);
        $product = new Product(['name' => 'Nokla', 'product_id' => 32]);
        $resource = $this->getMock('App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will(
                $this->returnValue([['quantity' => 1, 'product_id' => 32, 'customer_id' => 1]])
            );

        $quoteItem = new QuoteItem(['quantity' => 1, 'product_id' => 32, 'customer_id' => 1]);

        $this->assertEquals($quoteItem, $quote->getItemForProduct($product, $resource));

    }

    public function testReturnsQuoteItemForProduct()
    {
        $quote = new Quote;
        $product = new Product(['name' => 'Nokla', 'product_id' => 32]);
        $resource = $this->getMock('App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will(
                $this->returnValue([['quantity' => 1, 'product_id' => 32, 'customer_id' => 1]])
            );


        $quoteItem = new QuoteItem(['quantity' => 1, 'product_id' => 32, 'customer_id' => 1]);

        $this->assertEquals($quoteItem, $quote->getItemForProduct($product, $resource));

    }

    public function testRemoveQuoteItemFromQuote()
    {
        $quote = new Quote;
        $quoteItem = new QuoteItem(['quote_item_id' => 1, 'product_id' => 32, 'quantity' => 1]);
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('remove')
            ->with(
                $this->equalTo(1)
            );

        $quote->removeItem($quoteItem, $resource);
    }
}
