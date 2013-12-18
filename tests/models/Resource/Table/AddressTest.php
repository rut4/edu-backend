<?php
namespace Test\Model\Resource\Table;

use App\Model\Resource\Table\City;

class CityTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsProductTableName()
    {
        $table = new City;
        $this->assertEquals('cities', $table->getName());
    }

    public function testReturnsProductTablePrimaryKey()
    {
        $table = new City;
        $this->assertEquals('city_id', $table->getPrimaryKey());
    }
}