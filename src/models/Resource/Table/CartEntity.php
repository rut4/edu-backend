<?php
namespace App\Model\Resource\Table;

class CartEntity
    implements ITable
{

    public function getName()
    {
        return 'cart';
    }

    public function getPrimaryKey()
    {
        return 'prepared_order_id';
    }
}