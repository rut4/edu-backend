<?php
namespace App\Model\Resource;

class DBCollection
    implements IResourceCollection
{
    private $_connection;
    private $_table;
    private $_filters = [];
    private $_bind = [];

    public function __construct(\PDO $connection, Table\ITable $table)
    {
        $this->_connection = $connection;
        $this->_table = $table->getName();
    }

    public function fetch()
    {
        $stmt = $this->_prepareSql();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function filterBy($column, $value)
    {
        $this->_filters[$column] = $value;
    }

    public function average($column)
    {
        $stmt = $this->_prepareSql("AVG({$column}) as avg");
        return $stmt->fetchColumn();
    }

    protected function _prepareSql($columns = '*')
    {
        $sql = "SELECT {$columns} FROM {$this->_table}";
        if ($this->_filters) {
            $sql .= ' WHERE ' . $this->_prepareFilters();
        }
        $stmt = $this->_connection
            ->prepare($sql);
        if ($this->_bind) {
            $this->_bindValues($stmt);
        }
        $stmt->execute();

        return $stmt;
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

    private function _bindValues(\PDOStatement $stmt)
    {
        foreach ($this->_bind as $parameter => $value) {
            $stmt->bindValue($parameter, $value);
        }
    }

}
