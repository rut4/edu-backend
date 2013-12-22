<?php
namespace App\Model\Resource;

interface IResourceEntity
{
    public function find($id);

    public function findBy($column, $value);

    public function save(array $data);

    public function remove($id);

    public function getPrimaryKeyField();
}