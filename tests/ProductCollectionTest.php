<?php

require_once __DIR__ . '/../src/models/Resource/IResourceCollection.php';
require_once __DIR__ . '/../src/models/ProductCollection.php';

class ProductCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testTakesDataFromResource()
    {
        $resource = $this->getMock('IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['name' => 'Nokla']
                ]
            ));

        $collection = new ProductCollection($resource);

        $products = $collection->getProducts();
        $this->assertEquals('Nokla', $products[0]->getName());
    }

    public function testIterableWithForeachFunction()
    {
        $resource = $this->getMock('IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['sku' => 'foo'],
                    ['sku' => 'bar']
                ]
            ));

        $expected = array(0 => 'foo', 1 => 'bar');
        $collection = new ProductCollection($resource);
        foreach ($collection as $_key => $item) {
            $this->assertEquals($expected[$_key], $item->getName());
        }
    }
}