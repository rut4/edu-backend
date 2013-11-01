<?php
require_once __DIR__ . '/../src/ProductCollection.php';
require_once __DIR__ . '/../src/Product.php';

class ProductCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testResultingProductsEqualsGivenProducts()
    {
        $products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar'])]);
        $this->assertEquals([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar'])], $products->getProducts());

        $products = new ProductCollection([new Product(['sku' => 'baz'])]);
        $this->assertEquals([new Product(['sku' => 'baz'])], $products->getProducts());
    }

    public function testResultingSizeEqualsGivenProductCollectionSize()
    {
        $products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar'])]);
        $this->assertEquals(2, $products->getSize());

        $products = new ProductCollection([]);
        $this->assertEquals(0, $products->getSize());
    }

    public function testResultingProductsCountMustBeEqualsOrLessGivenLimit()
    {
        $products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']),
            new Product(['sku' => 'baz'])]);

        $products->limit(15);
        $this->assertEquals(3, $products->getSize());

        $products->limit(1);
        $this->assertEquals(1, $products->getSize());
    }

    public function testOffsetMustBeShiftProducts()
    {
        $products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']),
            new Product(['sku' => 'baz'])]);

        $products->offset(0);
        $this->assertEquals([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])],
            $products->getProducts());

        $products->offset(1);
        $this->assertEquals([new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])], $products->getProducts());

        $products->offset(-1);
        $this->assertEquals([new Product(['sku' => 'baz'])], $products->getProducts());
    }
}
