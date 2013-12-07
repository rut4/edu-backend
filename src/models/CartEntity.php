<?php
namespace App\Model;

use \App\Model\Resource\IResourceEntity;

class CartEntity
    extends CollectionElement
{
    public function getId()
    {
        return $this['prepared_order_id'];
    }

    public function getProductId()
    {
        return $this['product_id'];
    }

    public function getCustomerId()
    {
        return $this['customer_id'];
    }

    public function getSessionId()
    {
        return $this['session_id'];
    }

    public function getCount()
    {
        return $this['count'];
    }

    public function setCount($count)
    {
        $this->_data['count'] = $count;
    }

    public function save(IResourceEntity $resource)
    {
        $id = $resource->save($this->_data);
        $this->_data['prepared_order_id'] = $id;
    }
}