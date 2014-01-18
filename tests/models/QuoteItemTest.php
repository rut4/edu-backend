<?php
namespace Test\Model;
use App\Model\Product;
use \App\Model\QuoteItem;

class QuoteItemTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsIdWhichHasBeenInitialized()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('quote_item_id'));

        $item = new QuoteItem(['quote_item_id' => 1], $resource);
        $this->assertEquals(1, $item->getId());

        $item = new QuoteItem(['quote_item_id' => 2], $resource);
        $this->assertEquals(2, $item->getId());
    }

    public function testReturnsQtyWhichHasBeenInitialized()
    {
        $item = new QuoteItem(['quantity' => 10]);
        $this->assertEquals(10, $item->getQuantity());
    }

    public function testReceivesDataAsArray()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('quote_item_id'));

        $item = new QuoteItem([], $resource);
        $item->setData(['quote_item_id' => 42]);
        $this->assertEquals(42, $item->getId());
    }

    public function testReturnsProductIdWhichHasBeenInitialized()
    {
        $item = new QuoteItem(['product_id' => 42]);
        $this->assertEquals(42, $item->getProductId());
    }

    public function testBelongsToProductIfHasSameProductId()
    {
        $productFoo = $this->getMock('App\Model\Product', ['getId']);
        $productFoo->expects($this->any())->method('getId')
            ->will($this->returnValue(42));

        $productBar = $this->getMock('App\Model\Product', ['getId']);
        $productBar->expects($this->any())->method('getId')
            ->will($this->returnValue(11));

        $item = new QuoteItem(['product_id' => 42]);
        $this->assertTrue($item->belongsToProduct($productFoo));
        $this->assertFalse($item->belongsToProduct($productBar));
    }

    public function testAddsQtyToCurrentValue()
    {
        $item = new QuoteItem(['quantity' => 10]);
        $item->addQuantity(1);

        $this->assertEquals(11, $item->getQuantity());
    }

    public function testAssignProductSetsProductId()
    {
        $product = $this->getMock('App\Model\Product', ['getId']);
        $product->expects($this->any())->method('getId')
            ->will($this->returnValue(42));
        $item = new QuoteItem;
        $item->assignToProduct($product);

        $this->assertEquals(42, $item->getProductId());
    }

    public function testAssignProductSetsProductInstance()
    {
        $product = $this->getMock('App\Model\Product', ['getId', 'load']);
        $product->expects($this->at(0))->method('getId')
            ->will($this->returnValue(42));
        $product->expects($this->at(1))->method('load')
            ->with($this->equalTo(42));
        $item = new QuoteItem;
        $item->assignToProduct($product);

        $this->assertEquals($product, $item->getProduct());
    }
}
