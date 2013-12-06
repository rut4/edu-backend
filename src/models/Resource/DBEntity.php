<?php
namespace App\Model\Resource;

class DBEntity
    implements IResourceEntity
{
    private $_connection;
    private $_table;

    public function __construct(\PDO $connection, Table\ITable $table)
    {
        $this->_connection = $connection;
        $this->_table = $table;
    }

    public function find($id)
    {
        $stmt = $this
            ->_connection
            ->prepare("SELECT * FROM {$this->_table->getName()} WHERE {$this->_table->getPrimaryKey()} = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function save(array $data)
    {
        $fields = array_keys($data);
        if ($this->_itemExists($data)) {
            $stmt = $this->_updateItem($fields);
        } else {
            $stmt = $this->_insertItem($fields);
        }
        $stmt->execute(array_combine($this->_prepareBind($fields), $data));
        return $this->_connection->lastInsertId($this->_table->getPrimaryKey());
    }

    public function remove($id)
    {
        $stmt = $this
            ->_connection
            ->prepare("DELETE FROM {$this->_table->getName()} WHERE {$this->_table->getPrimaryKey()} = :id");
        $stmt->execute([':id' => $id]);
    }

    private function _itemExists($data)
    {
        if (isset($data[$this->_table->getPrimaryKey()])) {
            $id = $this->find($data[$this->_table->getPrimaryKey()]);
            return (bool)$id;
        }
    }

    private function _updateItem($fields)
    {
        $update = array_map(function ($field) {
            return "{$field} = :{$field}";
        }, $fields);

        $updateList = implode(',', $update);
        $condition = "{$this->_table->getPrimaryKey()} = :{$this->_table->getPrimaryKey()}";

        $stmt = $this->_connection->prepare(
            "UPDATE {$this->_table->getName()} SET {$updateList} WHERE {$condition}"
        );

        return $stmt;

    }

    private function _insertItem($fields)
    {
        $fieldsList = implode(',', $fields);
        $bindsList = implode(',', $this->_prepareBind($fields));

        $stmt = $this->_connection->prepare(
            "INSERT INTO {$this->_table->getName()} ({$fieldsList}) VALUES ({$bindsList})"
        );

        return $stmt;
    }

    private function _prepareBind($fields)
    {
        return array_map(function ($field) {
            return ":{$field}";
        }, $fields);
    }


}