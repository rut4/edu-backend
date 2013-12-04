<?php
namespace Test\Model\Resource;
use \App\Model\Resource\DBEntity;

class DBEntityTest
    extends \PHPUnit_Extensions_Database_TestCase
{
    public function testReturnsFoundDataFromDb()
    {
        $resource = $this->_getEntity();
        $this->assertEquals(['id' => 1, 'data' => 'foo', 'rating' => 1], $resource->find(1));
        $this->assertEquals(['id' => 2, 'data' => 'bar', 'rating' => 2], $resource->find(2));
    }

    public function testEscapesFilterParameter()
    {
        $resource = $this->_getEntity();

        $this->assertEquals(['id' => 2, 'data' => 'bar', 'rating' => 2], $resource->find('2-1'));
    }

    public function getConnection()
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=student_unit', 'root', 'vagrant');
        return $this->createDefaultDBConnection($pdo, 'student_unit');
    }

    public function getDataSet()
    {
        return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            __DIR__ . '/DBEntityTest/fixtures/abstract_entity.yaml'
        );
    }

    private function _getEntity()
    {
        $table = $this->getMock('\App\Model\Resource\Table\ITable');
        $table->expects($this->any())->method('getName')
            ->will($this->returnValue('abstract_entity'));
        $table->expects($this->any())->method('getPrimaryKey')
            ->will($this->returnValue('id'));
        $entity = new DBEntity($this->getConnection()->getConnection(), $table);
        return $entity;
    }
}
