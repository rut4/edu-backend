<?php
namespace Test\Model;

use App\Model\ProductCollection;
use App\Model\QuoteItemCollection;

class QuoteItemCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testTakesDataFromResource()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['product_id' => 123]
                ]
            ));

        $collection = new QuoteItemCollection($resource);

        $quoteItems = $collection->getItems();
        $this->assertEquals(123, $quoteItems[0]->getProductId());
    }

    public function testIsIterableWithForeachFunction()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['product_id' => 44],
                    ['product_id' => 55]
                ]
            ));

        $collection = new QuoteItemCollection($resource);
        $expected = array(0 => 44, 1 => 55);
        $iterated = false;
        foreach ($collection as $_key => $_product) {
            $this->assertEquals($expected[$_key], $_product->getProductId());
            $iterated = true;
        }

        if (!$iterated) {
            $this->fail('Iteration did not happen');
        }
    }

}
