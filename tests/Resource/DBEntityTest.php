<?php
require_once __DIR__ . '/../../src/models/Resource/DBEntity.php';

class DBEntityTest
    extends PHPUnit_Extensions_Database_TestCase
{
    public function testRetunsFoundDataFromDb()
    {
        $resource = new DBEntity(
            $this->getConnection()->getConnection(), 'abstract_collection', 'id'
        );
        $this->assertEquals(['id' => 1, 'data' => 'foo', 'rating' => 1], $resource->find(1));
        $this->assertEquals(['id' => 2, 'data' => 'bar', 'rating' => 2], $resource->find(2));
    }

    public function getConnection()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=student_unit', 'root', 'vagrant');
        return $this->createDefaultDBConnection($pdo, 'student_unit');
    }

    public function getDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            __DIR__ . '/DBEntityTest/fixtures/abstract_entity.yaml'
        );
    }
}
