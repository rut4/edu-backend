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
        $resource = $this->getMock('App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will(
                $this->returnValue([['quantity' => 1, 'product_id' => 32, 'customer_id' => 1]])
            );
        $customer = new Customer(['customer_id', 1]);
        $quote = new Quote($resource);
        $quote->loadByCustomer($customer);
        $product = new Product(['name' => 'Nokla', 'product_id' => 32]);


        $quoteItem = new QuoteItem(['quantity' => 1, 'product_id' => 32, 'customer_id' => 1]);

        $this->assertEquals($quoteItem, $quote->getItemForProduct($product));

    }

    public function testReturnsQuoteItemForProduct()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will(
                $this->returnValue([['quantity' => 1, 'product_id' => 32, 'customer_id' => 1]])
            );
        $quote = new Quote($resource);
        $product = new Product(['name' => 'Nokla', 'product_id' => 32]);
        $quoteItem = new QuoteItem(['quantity' => 1, 'product_id' => 32, 'customer_id' => 1]);

        $this->assertEquals($quoteItem, $quote->getItemForProduct($product));

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

    public function testReturnsUserItems()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will(
                $this->returnValue([[
                    'product_id' => 1,
                    'customer_id' => 1
                ]])
            );
        $quote = new Quote($resource);
        $quote->loadByCustomer(new Customer(['customer_id' => 1]));
        $expected = ['product_id' => 1, 'customer_id' => 1];

        $this->assertEquals([new QuoteItem($expected)], $quote->getItemsForUser());
    }

    public function testRetunrsAssignedAddress()
    {
        $address = $this->getMock('App\Model\Address', ['load']);
        $address->expects($this->once())
            ->method('load')
            ->with($this->equalTo(42));

        $quote = new Quote(null, ['address_id' => 42], $address);
        $quote->getAddress();

        $this->assertSame($address, $quote->getAddress());
    }

    public function testCreatesNewAddressIfNotAssigned()
    {
        $address = $this->getMock('App\Model\Address', ['getId', 'save']);
        $address->expects($this->once())
            ->method('save');
        $address->expects($this->once())
            ->method('getId')
            ->will($this->returnValue(42));

        $quoteResource = $this->getMock('App\Model\Resource\IResourceEntity', []);

        $quote = new Quote($quoteResource, [], $address);
        $quoteResource->expects($this->once())
            ->method('save')
            ->with($this->equalTo(['address_id' => 42]));

        $quote->getAddress();
    }


}
