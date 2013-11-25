<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 25.11.13
 * Time: 19:59
 */

class DBEntityTest extends PHPUnit_Extensions_Database_TestCase
{

    public function testReturnsFoundDataFromDb()
    {
        $resource = new DBEntity(
            $thi
        )
        $this->assertEquals(['id' => 1, 'data' => 'foo'], $resource)
    }

    /**
     * Returns the test database connection.
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection()
    {

    }

    /**
     * Returns the test dataset.
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        // TODO: Implement getDataSet() method.
    }
}