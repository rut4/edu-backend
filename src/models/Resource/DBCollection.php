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

    public function fetch()
    {
        return $this->_connection->query("SELECT * FROM {$this->_table}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchFilter($field, $value)
    {
        $statement = $this->_connection->prepare("SELECT * FROM {$this->_table} WHERE :field = :value");
        $statement->execute([
            'field' => $field,
            'value' => $value
        ]);
        // return $statement->fetchAll(PDO::FETCH_ASSOC);

        return $this->_connection->query("SELECT * FROM {$this->_table} WHERE {$field} = {$value}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }


    public function fetchAvg($field)
    {
        $statement = $this->_connection->prepare("SELECT AVG(:field) FROM {$this->_table}");
        $statement->execute(['field' => $field]);
        // return $statement->fetch(PDO::FETCH_COLUMN);

        return $this->_connection->query("SELECT AVG({$field}) FROM {$this->_table}")
            ->fetch(PDO::FETCH_COLUMN);
    }

    public function fetchAvgFilter($field, $filterField, $value)
    {
        $statement = $this->_connection->prepare("SELECT AVG(:field) FROM {$this->_table} WHERE :filterField = :value");
        $statement->execute([
            'field' => $field,
            'filterField' => $filterField,
            'value' => $value
        ]);
        // return $statement->fetch(PDO::FETCH_COLUMN);

        return $this->_connection->query("SELECT AVG({$field}) FROM {$this->_table} WHERE {$filterField} = {$value}")
            ->fetch(PDO::FETCH_COLUMN);
    }
}
