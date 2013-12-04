<?php
namespace App\Model\Resource;

class DBEntity
    implements IResourceEntity
{
    private $_connection;
    private $_table;
    private $_primaryKey;

    public function __construct(\PDO $connection, Table\ITable $table)
    {
        $this->_connection = $connection;
        $this->_table = $table->getName();
        $this->_primaryKey = $table->getPrimaryKey();
    }

    public function find($id)
    {
        $stmt = $this
            ->_connection
            ->prepare("SELECT * FROM {$this->_table} WHERE {$this->_primaryKey} = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}