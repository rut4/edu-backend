<?php
require_once __DIR__ . '/../src/models/Product.php';

class ProductTest extends PHPUnit_Framework_TestCase
{
    public function testReturnsSkuWhichHasBeenInitialized()
    {
        $product = new Product(['sku' => '12345']);
        $this->assertEquals('12345', $product->getSku());

        $product = new Product(['sku' => '567890']);
        $this->assertEquals('567890', $product->getSku());
    }

    public function testReturnsNameWhichHasBeenInitialized()
    {
        $product = new Product(['name' => 'Nokio']);
        $this->assertEquals('Nokio', $product->getName());

        $product = new Product(['name' => 'Motorobla']);
        $this->assertEquals('Motorobla', $product->getName());
    }

    public function testReturnsImageWhichHasBeenInitialized()
    {
        $product = new Product(['image' => 'http://url.ru/img.jpg']);
        $this->assertEquals('http://url.ru/img.jpg', $product->getImage());

        $product = new Product(['image' => 'http://url.ru/img2.jpg']);
        $this->assertEquals('http://url.ru/img2.jpg', $product->getImage());
    }

    public function testReturnsPriceWhichHasBeenInitialized()
    {
        $product = new Product(['price' => 123.5]);
        $this->assertEquals(123.5, $product->getPrice());

        $product = new Product(['price' => 42]);
        $this->assertEquals(42, $product->getPrice());
    }

    public function testReturnsSpecialPriceWhichHasBeenInitialized()
    {
        $product = new Product(['special_price' => 123.5]);
        $this->assertEquals(123.5, $product->getSpecialPrice());

        $product = new Product(['special_price' => 42]);
        $this->assertEquals(42, $product->getSpecialPrice());
    }

    public function testSpecialPriceIsAppliedWhenValueIsSet()
    {
        $product = new Product(['special_price' => 123.5]);
        $this->assertTrue($product->isSpecialPriceApplied());

        $product = new Product([]);
        $this->assertFalse($product->isSpecialPriceApplied());
    }
}
