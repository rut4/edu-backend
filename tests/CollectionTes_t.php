<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 01.11.13
 * Time: 10:32
 */
require_once __DIR__ . '/../src/models/Collection.php';
require_once __DIR__ . '/../src/models/ReviewCollection.php';
require_once __DIR__ . '/../src/models/Review.php';

class CollectionTest extends PHPUnit_Framework_TestCase
{
    public function testIterableWithForeachFunction()
    {
        $expected = array(0 => 'foo', 1 => 'bar');
        $collection = new ReviewCollection([new Review(['name' => 'foo']), new Review(['name' => 'bar'])]);
        foreach ($collection as $_key => $item) {
            $this->assertEquals($expected[$_key], $item->getName());
        }

        $expected = array(0 => 'Nokio', 1 => 'Motorobla');
        $collection = new ProductCollection([new Product(['name' => 'Nokio']), new Product(['name' => 'Motorobla'])]);
        foreach ($collection as $_key => $item) {
            $this->assertEquals($expected[$_key], $item->getName());
        }
    }

    public function testIterableCollectionLimitedByLimit()
    {
        $collection = new ReviewCollection([new Review(['name' => 'foo']), new Review(['name' => 'bar']),
            new Review(['name' => 'baz'])]);

        $collection->limit(2);
        $expected = array(0 => 'foo', 1 => 'bar');
        foreach ($collection as $_key => $item) {
            $this->assertEquals($expected[$_key], $item->getName());
        }

        $collection->limit(0);
        $expected = array();
        foreach ($collection as $_key => $item) {
            $this->assertEquals($expected[$_key], $item->getName());
        }
    }

    public function testIterableCollectionStartedAtOffset()
    {
        $collection = new ReviewCollection([new Review(['name' => 'foo']), new Review(['name' => 'bar']),
            new Review(['name' => 'baz'])]);

        $collection->offset(2);
        $expected = array(0 => 'baz');
        foreach ($collection as $_key => $item) {
            $this->assertEquals($expected[$_key], $item->getName());
        }

        $collection->offset(-3);
        $expected = array(0 => 'foo', 1 => 'bar', 2 => 'baz');
        foreach ($collection as $_key => $item) {
            $this->assertEquals($expected[$_key], $item->getName());
        }
    }

    public function testIterableCollectionLimitedByLimitAndOffset()
    {
        $collection = new ReviewCollection([new Review(['name' => 'foo']), new Review(['name' => 'bar']),
            new Review(['name' => 'baz'])]);

        $collection->offset(2);
        $collection->limit(0);
        $expected = array();
        foreach ($collection as $_key => $item) {
            $this->assertEquals($expected[$_key], $item->getName());
        }

        $collection->offset(2);
        $collection->limit(1);
        $expected = array(0 => 'baz');
        foreach ($collection as $_key => $item) {
            $this->assertEquals($expected[$_key], $item->getName());
        }

        $collection->offset(-2);
        $collection->limit(1);
        $expected = array(0 => 'bar');
        foreach ($collection as $_key => $item) {
            $this->assertEquals($expected[$_key], $item->getName());
        }

        $collection->offset(0);
        $collection->limit(15);
        $expected = array(0 => 'foo', 1 => 'bar', 2 => 'baz');
        foreach ($collection as $_key => $item) {
            $this->assertEquals($expected[$_key], $item->getName());
        }

        $collection->offset(10);
        $collection->limit(15);
        $expected = array();
        foreach ($collection as $_key => $item) {
            $this->assertEquals($expected[$_key], $item->getName());
        }
    }

    public function testCollectionSorting()
    {
        $productCollection = new ProductCollection([new Product(['sku' => 4, 'name' => 'Nokio']),
            new Product(['sku' => 2, 'name' => 'Motorobla']), new Product(['sku' => 3, 'name' => 'Sumsang'])]);

        $productCollection->sort('sku');
        $expected = [new Product(['sku' => 2, 'name' => 'Motorobla']), new Product(['sku' => 3, 'name' => 'Sumsang']),
            new Product(['sku' => 4, 'name' => 'Nokio'])];
        $this->assertEquals($expected, $productCollection->getProducts());


        $reviewsCollection = new ReviewCollection([new Review(['text' => 'nice']), new Review(['text' => 'awful']),
            new Review(['text' => 'good'])]);

        $reviewsCollection->sort('text');
        $expected = [new Review(['text' => 'awful']), new Review(['text' => 'good']), new Review(['text' => 'nice'])];
        $this->assertEquals($expected, $reviewsCollection->getReviews());
    }
}
