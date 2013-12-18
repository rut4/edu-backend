<?php
namespace Test\Model\Resource;

use App\Model\Resource\Paginator;

class PaginatorTest
    extends \PHPUnit_Framework_TestCase
{
    public function testAppliesLimitAndOffsetToCollection()
    {
        $collection = $this->getMock('\App\Model\Resource\IResourceCollection');
        $collection->expects($this->once())->method('limit')
            ->with(
                $this->equalTo(200),
                $this->equalTo(100)
            );

        $paginator = new Paginator($collection);
        $paginator->getItems($offset = 100, $itemsPerPage = 200);
    }

    public function testReturnsLimitedCollectionItems()
    {
        $collection = $this->getMock('\App\Model\Resource\IResourceCollection');
        $collection->expects($this->at(0))->method('limit');
        $collection->expects($this->at(1))->method('fetch')
            ->will($this->returnValue([['foo' => 'bar']]));

        $paginator = new Paginator($collection);
        $this->assertEquals([['foo' => 'bar']], $paginator->getItems(100, 200));
    }

    public function testReturnsCollectionCount()
    {
        $collection = $this->getMock('\App\Model\Resource\IResourceCollection');
        $collection->expects($this->once())->method('count')
            ->will($this->returnValue(42));

        $paginator = new Paginator($collection);
        $this->assertEquals(42, $paginator->count());
    }
}

