<?php

namespace App\Model;

use App\Model\Resource\IResourceEntity;

class QuoteItem
    extends CollectionElement
{
    public function getId()
    {
        return $this['quote_item_id'];
    }

    public function getProductId()
    {
        return $this['product_id'];
    }

    public function getCustomerId()
    {
        return $this['customer_id'];
    }

    public function getQuantity()
    {
        return $this['quantity'];
    }

    public function addQuantity($quantity)
    {
        if ($quantity > 0) {
            $this->_data['quantity'] += $quantity;
        }
    }

    public function deleteQuantity($quantity)
    {
        if ($quantity > 0 && $this->_data['quantity'] >= $quantity) {
            $this->_data['quantity'] -= $quantity;
        }
    }

    public function updateQuantity($quantity)
    {
        if ($quantity > 0) {
            $this->_data['quantity'] = $quantity;
        }
    }

    public function save(IResourceEntity $resource)
    {
        $id = $resource->save($this->_data);
        $this->_data['quote_item_id'] = $id;
    }
}
