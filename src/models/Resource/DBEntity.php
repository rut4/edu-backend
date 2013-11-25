<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 25.11.13
 * Time: 20:01
 */

class DBEntity implements IResourceEntity
{
    private $_connection;
    private $_table;
    private $_primaryKey;

    public function __construct(PDO $connection, $table, $primaryKey)
    {
        $this->_connection = $connection;
        $this->_table = $table;
        $this->_primaryKey = $primaryKey;
    }

    public function find($id)
    {
        $stmt = $this
            ->_connection
            ->prepare('SELECT * FROM :table WHERE :primary_key = :id');
        $stmt->execute(['table' => $this->_table, 'primary_key' => $this->_primaryKey, 'id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}