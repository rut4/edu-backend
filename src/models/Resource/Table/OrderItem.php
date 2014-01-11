<?php
namespace App\Model\Resource\Table;

class OrderItem
    implements ITable
{
    public function getName()
    {
        return 'order_items';
    }

    public function getPrimaryKey()
    {
        return 'order_items_id';
    }
}
  