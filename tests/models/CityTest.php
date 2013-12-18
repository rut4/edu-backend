<?php
namespace Test\Model;

use App\Model\Region;

class RegionTest
    extends \PHPUnit_Framework_TestCase
{
    public function testLoadsDataFromResource()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('find')
            ->with($this->equalTo(42))
            ->will($this->returnValue(['name' => 'RO']));

        $region = new Region([], $resource);
        $region->load(42);

        $this->assertEquals('RO', $region->getName());
    }
}
