<?php
require_once __DIR__ . '/../../src/models/Resource/DBCollection.php';
require_once __DIR__ . '/../../src/models/Resource/PDOHelper.php';

class DBCollectionTest
    extends PHPUnit_Extensions_Database_TestCase
{
    public function testFetchesDataFromDb()
    {
        $collection = new DBCollection($this->getConnection()->getConnection(), 'abstract_collection');

        $this->assertEquals([
            ['id' => 1, 'data' => 'foo', 'rating' => 4],
            ['id' => 2, 'data' => 'bar', 'rating' => 5]
        ], $collection->fetch());

        $collection->filterBy('rating', 4);
        $collection->filterBy('id', 1);
        $this->assertEquals([
            ['id' => 1, 'data' => 'foo', 'rating' => 4]
        ], $collection->fetch());
    }

    public function testFetchesAvgValueFromDb()
    {
        $collection = new DBCollection($this->getConnection()->getConnection(), 'abstract_collection');

        $this->assertEquals(4.5, $collection->fetchAvg('rating'));


        $collection->filterBy('id', 1);
        $this->assertEquals(4, $collection->fetchAvg('rating'));
    }

    public function getConnection()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=student_unit', 'root', 'vagrant');
        return $this->createDefaultDBConnection($pdo, 'student_unit');
    }

    public function getDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            __DIR__ . '/DBCollectionTest/fixtures/abstract_collection.yaml'
        );
    }
}
