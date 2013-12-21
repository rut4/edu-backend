<?php
namespace Test\Model;

use \App\Model\Customer;

class CustomerTest extends \PHPUnit_Framework_TestCase
{
    public function testSavesDataInResource()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('save')
            ->with($this->equalTo(['name' => 'Vasia']));
        $customer = new Customer(['name' => 'Vasia']);
        $customer->save($resource);
    }

    public function testGetsIdFromResourceAfterSave()
    {
        $resource = $this->getMock('App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('save')
            ->with($this->equalTo(['name' => 'Vasia']))
            ->will($this->returnValue(42));
        $resource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('customer_id'));

        $customer = new Customer(['name' => 'Vasia']);
        $customer->save($resource);
        $this->assertEquals(42, $customer->getId());
    }

    public function testReturnsIdWhichHasBeenInitialized()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('getPrimaryKeyField')
            ->will($this->returnValue('customer_id'));

        $customer = new Customer(['customer_id' => 1], $resource);
        $this->assertEquals(1, $customer->getId());

        $customer = new Customer(['customer_id' => 2], $resource);
        $this->assertEquals(2, $customer->getId());
    }
}
