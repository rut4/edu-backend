<?php
namespace App\Model;

class ProductReview extends Entity
{
    public function getName()
    {
        return $this->_getData('name');
    }

    public function getEmail()
    {
        return $this->_getData('email');
    }

    public function getText()
    {
        return $this->_getData('text');
    }

    public function getRating()
    {
        return $this->_getData('rating');
    }

    public function belongsToProduct(Product $product)
    {
        return $product == $this->_getData('product');
    }

    public function save()
    {
        $this->_resource->save($this->_data);
    }
}
