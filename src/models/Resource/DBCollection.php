<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 25.11.13
 * Time: 19:26
 */

class DBCollection implements  IResourceCollection
{
    private $_connection;
    private $_table;

    public function __construct(PDO $connection, $table)
    {
        $this->_connection = $connection;
        $this->_table = $table;
    }

    public function fetch()
    {
        $this->_connection->query("SELECT * FROM {$table}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }
} 