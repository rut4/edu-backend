<?php
namespace Test\Model\Resource\Table;

use App\Model\Resource\Table\Product;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsProductTableName()
    {
        $table = new Product;
        $this->assertEquals('products', $table->getName());
    }

    public function testReturnsProductTablePrimaryKey()
    {
        $table = new Product;
        $this->assertEquals('product_id', $table->getPrimaryKey());
    }
}