<?php
namespace Test\Model;

use \App\Model\ReviewCollection;
use \App\Model\Product;

class ReviewCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testTakesDataFromResource()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['name' => 'Vasya', 'rating' => 1]
                ]
            ));

        $collection = new ReviewCollection($resource);

        $products = $collection->getReviews();
        $this->assertEquals('Vasya', $products[0]->getName());
    }

    public function testIsIterableWithForeachFunction()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['name' => 'Vasya'],
                    ['name' => 'Petya']
                ]
            ));

        $collection = new ReviewCollection($resource);
        $expected = array(0 => 'Vasya', 1 => 'Petya');
        $iterated = false;
        foreach ($collection as $_key => $_review) {
            $this->assertEquals($expected[$_key], $_review->getName());
            $iterated = true;
        }

        if (!$iterated) {
            $this->fail('Iteration did not happen');
        }
    }


    /**
     * @dataProvider getProductIds
     */
    public function testFiltersCollectionByProduct($productId)
    {
        $product = new Product(['product_id' => $productId]);
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('filterBy')
            ->with($this->equalTo('product_id'), $this->equalTo($productId));

        $collection = new ReviewCollection($resource);

        $collection->filterByProduct($product);
    }

    public function getProductIds()
    {
        return [[1], [2]];
    }

    public function testCalculatesAverageRating()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('average')
            ->with($this->equalTo('rating'));

        $collection = new ReviewCollection($resource);
        $collection->getAverageRating();
    }
} 