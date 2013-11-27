<?php

class DBCollection
    implements IResourceCollection
{
    private $_connection;
    private $_table;

    public function __construct(PDO $connection, $table)
    {
        $this->_connection = $connection;
        $this->_table = $table;
    }

    public function fetch($what = '*')
    {
//        $stmt = $this->_connection->prepare('SELECT * FROM :table');
//        $stmt->bindParam(':table', $this->_table, PDO::PARAM_STR);
//        $stmt->execute();
//        print_r($stmt->fetchAll());
        return $this->_connection->query("SELECT {$what} FROM {$this->_table}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchFilter($field, $value, $what = '*')
    {
        return $this->_connection->query("SELECT {$what} FROM {$this->_table} WHERE {$field} = {$value}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }


    public function fetchAvg($field)
    {
        return $this->_connection->query("SELECT AVG({$field}) FROM {$this->_table}")
            ->fetch(PDO::FETCH_COLUMN);
    }

    public function fetchAvgFilter($field, $filterField, $value)
    {
        return $this->_connection->query("SELECT AVG({$field}) FROM {$this->_table} WHERE {$filterField} = {$value}")
            ->fetch(PDO::FETCH_COLUMN);
    }
}
