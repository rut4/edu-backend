<?php
namespace Test\Model\Resource;
use App\Model\Resource\DBCollection;

class DBCollectionTest
    extends \PHPUnit_Extensions_Database_TestCase
{
    public function testFetchesDataFromDb()
    {
        $collection = $this->_getCollection();
        $this->assertEquals([
            ['id' => 1, 'data' => 'foo'],
            ['id' => 2, 'data' => 'bar']
        ], $collection->fetch());
    }

    public function testFetchesFilteredData()
    {
        $collection = $this->_getCollection();
        $collection->filterBy('id', 1);
        $this->assertEquals([
            ['id' => 1, 'data' => 'foo']
        ], $collection->fetch());

        $collection = $this->_getCollection();
        $collection->filterBy('data', 'bar');
        $collection->filterBy('id', 2);
        $this->assertEquals([
            ['id' => 2, 'data' => 'bar']
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
     * @dataProvider getLimitAmounts
     */
    public function testLimitsItemsBySpecifiedAmount($limit)
    {
        $expected = [
            1 => [['id' => 1, 'data' => 'foo']],
            2 => [['id' => 1, 'data' => 'foo'], ['id' => 2, 'data' => 'bar']],
        ];
        $collection = $this->_getCollection();
        $collection->limit($limit);
        $this->assertEquals($expected[$limit], $collection->fetch());
    }

    /**
     * @dataProvider getOffsetAmounts
     */
    public function testOffsetsItemsToSpecifiedAmount($offset)
    {
        $expected = [
            1 => [['id' => 2, 'data' => 'bar'], ['id' => 3, 'data' => 'baz']],
            2 => [['id' => 3, 'data' => 'baz']],
        ];
        $collection = $this->_getCollection();
        $collection->limit(100, $offset);
        $this->assertEquals($expected[$offset], $collection->fetch());
    }

    public function getLimitAmounts()
    {
        return [
            [1],
            [2]
        ];
    }

    public function getOffsetAmounts()
    {
        return [
            [1],
            [2]
        ];
    }

    public function testCalculatesItemsCount()
    {
        $collection = $this->_getCollection();
        $collection->limit(0);
        $collection->filterBy('data', 'foo');

        $this->assertEquals(3, $collection->count());
    }

    public function getConnection()
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=student_unit', 'root', '123123');
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
