<?php
namespace Test\Model\Resource\Table;

use App\Model\Resource\Table\Region;

class RegionTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsProductTableName()
    {
        $table = new Region;
        $this->assertEquals('regions', $table->getName());
    }

    public function testReturnsProductTablePrimaryKey()
    {
        $table = new Region;
        $this->assertEquals('region_id', $table->getPrimaryKey());
    }
}