<?php
namespace Test\Model;

use App\Model\Quote;

class QuoteTest
    extends \PHPUnit_Framework_TestCase
{
    public function testLoadsItselfFromSession()
    {
        $quote = $this->getMock('App\Model\Quote', ['load']);
        $quote->expects($this->once())->method('load')
            ->with($this->equalTo(42));

        $session = $this->getMockBuilder('App\Model\Session')
            ->disableOriginalConstructor()->setMethods(['getQuoteId'])->getMock();
        $session->expects($this->any())->method('getQuoteId')
            ->will($this->returnValue(42));

        $quote->loadBySession($session);
    }

    public function testSetsNewQuoteIdToSessionIfQuoteDoesNotExist()
    {
        $quote = $this->getMock('App\Model\Quote', ['save', 'getId']);
        $quote->expects($this->once())->method('save');
        $quote->expects($this->any())->method('getId')
            ->will($this->returnValue(42));

        $session = $this->getMockBuilder('App\Model\Session')
            ->disableOriginalConstructor()->setMethods(['getQuoteId', 'setQuoteId'])->getMock();
        $session->expects($this->any())->method('getQuoteId')
            ->will($this->returnValue(null));
        $session->expects($this->once())->method('setQuoteId')
            ->will($this->returnValue(42));

        $quote->loadBySession($session);
    }

    public function testLoadsDataFromResource()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('quote_id'));
        $resource->expects($this->any())
            ->method('find')
            ->with($this->equalTo(42))
            ->will($this->returnValue(['quote_id' => 42]));

        $quote = new Quote([], $resource);
        $quote->load(42);

        $this->assertEquals(42, $quote->getId());
    }

    public function testSavesDataInResource()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('save')
            ->with($this->equalTo(['quote_id' => 42]));

        $quote = new Quote(['quote_id' => 42], $resource);
        $quote->save();
    }

    public function testGetsIdFromResourceAfterSave()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('save')
            ->with($this->equalTo(['foo' => 'bar']))
            ->will($this->returnValue(42));
        $resource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('quote_id'));

        $quote = new Quote(['foo' => 'bar'], $resource);
        $quote->save();
        $this->assertEquals(42, $quote->getId());
    }

    public function testReturnsIdWhichHasBeenInitialized()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('quote_id'));

        $quote = new Quote(['quote_id' => 42], $resource);
        $this->assertEquals(42, $quote->getId());
    }

    public function testReturunsFilteredItemsCollection()
    {
        $itemsCollection = $this->getMockBuilder('\App\Model\QuoteItemCollection')
            ->disableOriginalConstructor()->setMethods(['filterByQuote'])->getMock();
        $quote = new Quote([], null, $itemsCollection);

        $itemsCollection->expects($this->once())->method('filterByQuote')
            ->with($this->equalTo($quote));

        $this->assertEquals($itemsCollection, $quote->getItems());
    }

    public function testReturnsAssginedAddress()
    {
        $address = $this->getMock('App\Model\Address', ['load']);
        $address->expects($this->once())
            ->method('load')
            ->with($this->equalTo(42))
        ;
        $quote = new Quote(['address_id' => 42], null, null, $address);

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

        $quoteResource = $this->getMock('App\Model\Resource\IResourceEntity');
        $quoteResource->expects($this->once())
            ->method('save')
            ->with($this->equalTo(['address_id' => 42]));

        $quote = new Quote([], $quoteResource, null, $address);

        $this->assertSame($address, $quote->getAddress());
    }
}

