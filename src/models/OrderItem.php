<?php
namespace App\Model;

class OrderItem
    extends CollectionElement
{
    private $_order;

    public function assignToOrder(Order $order)
    {
        $this->_order = $order;
        $this->_data['order_id'] = $order->getId();
        $this->save();
    }

    public function getOrder()
    {
        return $this->_order;
    }
}
