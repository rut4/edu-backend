<?php

class DBCollection
    implements IResourceCollection
{
    private $_connection;
    private $_table;
    private $_filters = [];
    private $_bind = [];

    public function __construct(PDO $connection, $table)
    {
        $this->_connection = $connection;
        $this->_table = $table;
    }

    public function fetch()
    {
        $sql = "SELECT * FROM {$this->_table}";
        if ($this->_filters)
        {
            $sql .= ' WHERE ' . $this->_prepareFilters();
        }
        $statement = $this->_connection->prepare($sql);
        if ($this->_bind) {
            $this->_bindParams($statement);
        }
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filterBy($column, $value)
    {
        $this->_filters[$column] = $value;
    }


    public function fetchAvg($column)
    {
        $sql = "SELECT AVG({$column}) FROM {$this->_table}";
        if ($this->_filters)
        {
            $sql .= ' WHERE ' . $this->_prepareFilters();
        }
        $statement = $this->_connection->prepare($sql);
        if ($this->_bind) {
            $this->_bindParams($statement);
        }
        $statement->execute();
        return $statement->fetchColumn();
    }

    private function _prepareFilters()
    {
        $conditions = [];
        foreach ($this->_filters as $column => $value) {
            $parameter = ':_param_' . $column;
            $conditions[] = $column . ' = ' . $parameter . '';
            $this->_bind[$parameter] = $value;
        }
        return implode(' AND ', $conditions);
    }

    private function _bindParams(PDOStatement $stmt)
    {
        foreach($this->_bind as $parameter => $value) {
            $stmt->bindValue($parameter, $value);
        }
    }
}
