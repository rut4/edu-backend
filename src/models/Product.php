<?php
namespace App\Model;

use App\Model\Resource\IResourceEntity;

class Product extends CollectionElement
{
    public function getSku()
    {
        return $this['sku'];
    }

    public function getName()
    {
        return $this['name'];
    }

    public function getImage()
    {
        return $this['image'];
    }

    public function getPrice()
    {
        return $this['price'];
    }

    public function getSpecialPrice()
    {
        return $this['special_price'];
    }
    public function getId()
    {
        return $this['product_id'];
    }

    public function isSpecialPriceApplied()
    {
        return $this->getSpecialPrice() > 0;
    }

    public function save(IResourceEntity $resource = null)
    {
        if (!$resource) {
            $resource = $this->_resource;
        }
        $id = $resource->save($this->_data);
        $this->_data['product_id'] = $id;
    }
}
