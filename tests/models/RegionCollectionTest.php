<?php
namespace Test\Model;
use \App\Model\ProductCollection;
use App\Model\Region;
use App\Model\RegionCollection;

class RegionCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testTakesDataFromResource()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['name' => 'RO']
                ]
            ));

        $collection = new RegionCollection($resource, new Region);

        $regions = $collection->getRegions();
        $this->assertEquals('RO', $regions[0]->getName());
    }

    public function testIsIterableWithForeachFunction()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['name' => 'foo'],
                    ['name' => 'bar']
                ]
            ));

        $collection = new RegionCollection($resource, new Region);
        $expected = array(0 => 'foo', 1 => 'bar');
        $iterated = false;
        foreach ($collection as $_key => $_region) {
            $this->assertEquals($expected[$_key], $_region->getName());
            $iterated = true;
        }

        if (!$iterated) {
            $this->fail('Iteration did not happen');
        }
    }

}
