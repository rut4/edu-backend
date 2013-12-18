<?php
namespace Test\Model\Resource\Table;

use App\Model\Resource\Table\Address;

class AddressTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsProductTableName()
    {
        $table = new Address;
        $this->assertEquals('addresses', $table->getName());
    }

    public function testReturnsProductTablePrimaryKey()
    {
        $table = new Address;
        $this->assertEquals('address_id', $table->getPrimaryKey());
    }
}