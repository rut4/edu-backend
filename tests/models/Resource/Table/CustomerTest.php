<?php
namespace Test\Model\Resource\Table;

use App\Model\Resource\Table\Customer;

class CustomerTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsCustomerTableName()
    {
        $table = new Customer;
        $this->assertEquals('customers', $table->getName());
    }

    public function testReturnsCustomerPrimaryKey()
    {
        $table = new Customer;
        $this->assertEquals('customer_id', $table->getPrimaryKey());
    }
}
