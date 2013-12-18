<?php
namespace Test\Model;

use App\Model\City;

class CityTest
    extends \PHPUnit_Framework_TestCase
{
    public function testLoadsDataFromResource()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('find')
            ->with($this->equalTo(42))
            ->will($this->returnValue(['name' => 'Taganrog']));

        $city = new City([], $resource);
        $city->load(42);

        $this->assertEquals('Taganrog', $city->getName());
    }
}
