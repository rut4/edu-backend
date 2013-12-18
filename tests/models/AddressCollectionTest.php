<?php
namespace Test\Model;

use App\Model\AddressCollection;

class AddressCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testTakesDataFromResource()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['city_id' => '1']
                ]
            ));

        $collection = new AddressCollection($resource);

        $addresses = $collection->getAddresses();
        $this->assertEquals('1', $addresses[0]->getCityId());
    }

    public function testIsIterableWithForeachFunction()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['street' => 'foo'],
                    ['street' => 'bar']
                ]
            ));

        $collection = new AddressCollection($resource);
        $expected = array(0 => 'foo', 1 => 'bar');
        $iterated = false;
        foreach ($collection as $_key => $_address) {
            $this->assertEquals($expected[$_key], $_address->getStreet());
            $iterated = true;
        }

        if (!$iterated) {
            $this->fail('Iteration did not happen');
        }
    }

}
