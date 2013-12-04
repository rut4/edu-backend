<?php
namespace App\Model\Resource\Table;

class Product
    implements ITable
{
    public function getName()
    {
        return 'products';
    }

    public function getPrimaryKey()
    {
        return 'product_id';
    }
}