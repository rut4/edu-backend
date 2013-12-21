<?php
namespace Test\Model\Resource;


use App\Model\QuoteItem;
use App\Model\Product;
use App\Model\QuoteItemCollection;

class QuoteItemPrototypeMock
    extends QuoteItem
{
    private $_saved = false;

    public function save()
    {
        $this->_saved = true;
    }

    public function wasSaved()
    {
        return $this->_saved;
    }
}

class QuoteItemProductMock
    extends Product
{
    private $_loadeWith;

    public function load($id)
    {
        $this->_loadeWith = $id;
    }

    public function getId()
    {
        return $this->_loadeWith;
    }
}

class QuoteItemCollectionTest
    extends \PHPUnit_Framework_TestCase
{
    public function testFiltersItemsByQuoteId()
    {
        $items = $this->getMock('App\Model\Resource\IResourceCollection');
        $items->expects($this->once())->method('filterBy')
            ->with($this->equalTo('quote_id'), $this->equalTo(42));

        $quote = $this->getMock('App\Model\Quote', ['getId']);
        $quote->expects($this->any())->method('getId')
            ->will($this->returnValue(42));

        $quoteItems = new QuoteItemCollection($items, new QuoteItem());
        $quoteItems->filterByQuote($quote);
    }

    public function testTakesDataFromResource()
    {
        $itemResource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $itemResource->expects($this->any())->method('getPrimaryKeyField')
            ->will($this->returnValue('item_id'));
        $item = new QuoteItem([], $itemResource);

        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['item_id' => 42]
                ]
            ));
        $collection = new QuoteItemCollection($resource, $item);

        $items = $collection->getItems();
        $this->assertEquals(42, $items[0]->getId());
    }

    public function testIsIterableWithForeachFunction()
    {
        $itemResource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $itemResource->expects($this->any())->method('getPrimaryKeyField')
            ->will($this->returnValue('item_id'));
        $item = new QuoteItem([], $itemResource);

        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['item_id' => 10],
                    ['item_id' => 20]
                ]
            ));

        $collection = new QuoteItemCollection($resource, $item);
        $expected = array(0 => 10, 1 => 20);
        $iterated = false;
        foreach ($collection as $_key => $quoteItem) {
            $this->assertEquals($expected[$_key], $quoteItem->getId());
            $iterated = true;
        }

        if (!$iterated) {
            $this->fail('Iteration did not happen');
        }
    }

    public function testFindsItemForProduct()
    {
        $product = new \App\Model\Product();

        $belongs = $this->getMock('App\Model\QuoteItem', ['belongsToProduct']);
        $belongs->expects($this->any())->method('belongsToProduct')
            ->with($this->equalTo($product))
            ->will($this->returnValue(true));

        $notBelongs = $this->getMock('App\Model\QuoteItem', ['belongsToProduct']);
        $notBelongs->expects($this->any())->method('belongsToProduct')
            ->with($this->equalTo($product))
            ->will($this->returnValue(false));

        $collection = $this->getMockBuilder('App\Model\QuoteItemCollection')
            ->disableOriginalConstructor()->setMethods(['getItems'])->getMock();
        $collection->expects($this->any())->method('getItems')
            ->will($this->returnValue([$belongs, $notBelongs]));

        $this->assertEquals($belongs, $collection->forProduct($product));
    }

    public function testCreatesNewItemForProductIfNotFound()
    {
        $product = $this->getMock('App\Model\Product', ['getId']);
        $product->expects($this->any())->method('getId')
            ->will($this->returnValue(42));

        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue([]));
        $collection = new QuoteItemCollection($resource, new QuoteItemPrototypeMock());

        $newItem = $collection->forProduct($product);
        $this->assertTrue($newItem->wasSaved());
        $this->assertTrue($newItem->belongsToProduct($product));
    }

    public function testAssignsProductsToItems()
    {
        $itemFoo = new QuoteItem(['product_id' => 1]);
        $itemBar = new QuoteItem(['product_id' => 2]);

        $collection = $this->getMockBuilder('App\Model\QuoteItemCollection')
            ->disableOriginalConstructor()->setMethods(['getItems'])->getMock();
        $collection->expects($this->any())->method('getItems')
            ->will($this->returnValue([$itemFoo, $itemBar]));

        $collection->assignProducts(new QuoteItemProductMock());

        $this->assertEquals(1, $itemFoo->getProduct()->getId());
        $this->assertEquals(2, $itemBar->getProduct()->getId());
    }
}
