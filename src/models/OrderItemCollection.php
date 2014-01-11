<?php
namespace App\Model;

class OrderItemCollection
    implements \IteratorAggregate
{
    private $_resource;
    private $_prototype;

    public function __construct(Resource\IResourceCollection $resource, OrderItem $orderItemPrototype)
    {
        $this->_resource = $resource;
        $this->_prototype = $orderItemPrototype;
    }

    public function getOrderItems()
    {
        return array_map(
            function ($data) {
                $orderItem = clone $this->_prototype;
                $orderItem->setData($data);
                return $orderItem;
            },
            $this->_resource->fetch()
        );
    }

    public function filterByOrder(Order $order)
    {
        $this->_prototype->assignToOrder($order);
        $this->_resource->filterBy('order_id', $order->getId());
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getOrderItems());
    }
}
