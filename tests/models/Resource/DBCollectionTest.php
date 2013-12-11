<?php
namespace Test\Model\Resource;

use \App\Model\Resource\DBCollection;

class DBCollectionTest
    extends \PHPUnit_Extensions_Database_TestCase
{
    public function testFetchesDataFromDb()
    {
        $collection = $this->_getCollection();
        $this->assertEquals([
            ['id' => 1, 'data' => 'foo', 'rating' => 4],
            ['id' => 2, 'data' => 'bar', 'rating' => 5]
        ], $collection->fetch());
    }

    public function testFetchesFilteredData()
    {
        $collection = $this->_getCollection();
        $collection->filterBy('id', 1);
        $this->assertEquals([
            ['id' => 1, 'data' => 'foo', 'rating' => 4]
        ], $collection->fetch());

        $collection = $this->_getCollection();
        $collection->filterBy('data', 'bar');
        $collection->filterBy('id', 2);
        $this->assertEquals([
            ['id' => 2, 'data' => 'bar', 'rating' => 5]
        ], $collection->fetch());
    }

    /**
     * @dataProvider getColumns
     */
    public function testCalculatesAverageAmountByColumn($column, $number)
    {
        $expected = [
            1 => (1+2+3)/3,
            2 => (10+11+12)/3
        ];
        $collection = $this->_getCollection();
        $this->assertEquals($expected[$number], $collection->average($column));
    }

    public function getColumns()
    {
        return [['id', 1],['data', 2]];
    }


    /**
     * @dataProvider getLimitsAmount
     */
    public function testLimitsItemsBySpecifiedAmount($limit)
    {
        $expected = [
            1 => [['id' => 1, 'data' => 'foo', 'rating' => 4]],
            2 => [['id' => 1, 'data' => 'foo', 'rating' => 4], ['id' => 2, 'data' => 'bar', 'rating' => 5]]
        ];

        $resource = $this->_getCollection();
        $resource->limit($limit);

        $this->assertEquals($expected[$limit], $resource->fetch());
    }

    public function getLimitsAmount()
    {
        return [[1], [2]];
    }

    /**
     * @dataProvider getOffsetAmounts
     */
    public function testOffsetItemsBySpecifiedAmount($offset)
    {
        $expected = [
            1 => [['id' => 2, 'data' => 'bar', 'rating' => 5], ['id' => 3, 'data' => 'baz', 'rating' => 5]],
            2 => [['id' => 3, 'data' => 'baz', 'rating' => 5]]
        ];

        $resource = $this->_getCollection();
        $resource->limit(2, $offset);

        $this->assertEquals($expected[$offset], $resource->fetch());
    }


    public function getOffsetAmounts()
    {
        return [[1], [2]];
    }

    public function testCalculatesItemsCount()
    {
        $resource = $this->_getCollection();
        $resource->limit(0);

        $count = $resource->count();
        $this->assertEquals(3, $count);
    }

    public function getConnection()
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=student_unit', 'root', 'vagrant');
        return $this->createDefaultDBConnection($pdo, 'student_unit');
    }

    public function getDataSet()
    {
        return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            __DIR__ . '/DBCollectionTest/fixtures/' . $this->getName(false) . '.yaml'
        );
    }

    private function _getCollection()
    {
        $table = $this->getMock('\App\Model\Resource\Table\ITable');
        $table->expects($this->any())->method('getName')
            ->will($this->returnValue('abstract_collection'));
        $collection = new DBCollection($this->getConnection()->getConnection(), $table);
        return $collection;
    }
}
