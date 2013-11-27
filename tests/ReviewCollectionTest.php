<?php
require_once __DIR__ . '/../src/models/ReviewCollection.php';

class ReviewCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testTakesDataFromResource()
    {
        $resource = $this->getMock('IResourceCollection');
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
        $resource = $this->getMock('IResourceCollection');
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
        foreach ($collection as $_key => $_product) {
            $this->assertEquals($expected[$_key], $_product->getName());
            $iterated = true;
        }

        if (!$iterated) {
            $this->fail('Iteration did not happen');
        }
    }

    public function testTakesAverageRating()
    {
        $resource = $this->getMock('IResourceCollection');
        $resource->expects($this->any())
            ->method('fetchAvg')
            ->will($this->returnValue(4.5));

        $collection = new ReviewCollection($resource);

        $this->assertEquals(4.5, $collection->getAverageRating());
    }
} 