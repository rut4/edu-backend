<?php
require_once __DIR__ . '/../src/models/Resource/IResourceCollection.php';
require_once __DIR__ . '/../src/models/ProductCollection.php';

class __ProductCollection extends PHPUnit_Framework_TestCase
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

    public function testIsIterableWithForeachFunction()
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

        $collection = new ProductCollection($resource);
        $expected = array(0 => 'foo', 1 => 'bar');
        $iterated = false;
        foreach ($collection as $_key => $_product) {
            $this->assertEquals($expected[$_key], $_product->getSku());
            $iterated = true;
        }

        if (!$iterated) {
            $this->fail('Iteration did not happen');
        }
    }

}
