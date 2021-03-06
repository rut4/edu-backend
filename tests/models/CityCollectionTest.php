<?php
namespace Test\Model;

use App\Model\City;
use App\Model\CityCollection;
use App\Model\Resource\DBEntity;
use App\Model\Resource\PDOHelper;

class CityCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testTakesDataFromResource()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceCollection');
        $resource->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue(
                [
                    ['name' => 'Taganrog']
                ]
            ));

        $collection = new CityCollection($resource, new City([], new DBEntity(PDOHelper::getPdo(), new \App\Model\Resource\Table\City)));

        $cities = $collection->getCities();
        $this->assertEquals('Taganrog', $cities[0]->getName());
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

        $collection = new CityCollection($resource, new City([], new DBEntity(PDOHelper::getPdo(), new \App\Model\Resource\Table\City)));
        $expected = array(0 => 'foo', 1 => 'bar');
        $iterated = false;
        foreach ($collection as $_key => $_city) {
            $this->assertEquals($expected[$_key], $_city->getName());
            $iterated = true;
        }

        if (!$iterated) {
            $this->fail('Iteration did not happen');
        }
    }

}
