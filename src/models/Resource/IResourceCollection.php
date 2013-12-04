<?php
namespace App\Model\Resource;

interface IResourceCollection
{
    public function fetch();

    public function filterBy($column, $value);

    public function average($column);
}
