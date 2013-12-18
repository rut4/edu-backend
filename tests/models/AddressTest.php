<?php
namespace Test\Model;

use App\Model\Address;

class AddressTest
    extends \PHPUnit_Framework_TestCase
{
    public function testLoadsDataFromResource()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('find')
            ->with($this->equalTo(42))
            ->will($this->returnValue(['street' => 'Chekhova']));

        $region = new Address([], $resource);
        $region->load(42);

        $this->assertEquals('Chekhova', $region->getStreet());
    }
}
