<?php
namespace App\Model;

class OrderItem
    extends CollectionElement
{
    private $_order;

    public function assignToOrder(Order $order)
    {
        $this->_order = $order;
    }

    public function getOrder()
    {
        return $this->_order;
    }
}
