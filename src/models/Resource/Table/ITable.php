<?php
namespace App\Model\Resource\Table;

interface ITable
{
    public function getName();

    public function getPrimaryKey();
}