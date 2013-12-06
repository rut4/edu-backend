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

        $customer = new Customer(['name' => 'Vasia']);
        $customer->save($resource);
        $this->assertEquals(42, $customer->getId());
    }

    public function testReturnsIdWhichHasBeenInitialized()
    {
        $customer = new Customer(['customer_id' => '12345']);
        $this->assertEquals('12345', $customer->getId());

        $customer = new Customer(['customer_id' => '567890']);
        $this->assertEquals('567890', $customer->getId());
    }

    public function testReturnsNameWhichHasBeenInitialized()
    {
        $customer = new Customer(['name' => 'Vasia']);
        $this->assertEquals('Vasia', $customer->getName());

        $customer = new Customer(['name' => 'Petia']);
        $this->assertEquals('Petia', $customer->getName());
    }
}