<?php

namespace App\Model;

use App\Model\Resource\IResourceEntity;

class Review extends CollectionElement
{

    private $_product;

    public function __construct(array $data = [],  Resource\IResourceEntity $resource = null, Product $product)
    {
        if (isset($data['rating']) && !in_array($data['rating'], [1, 2, 3, 4, 5])) {
            throw new \InvalidArgumentException('Rating value mast be in range [1, 5] and integer');
        }
        $this->_product = $product;
        parent::__construct($data, $resource);
    }

    public function getName()
    {
        return $this['name'];
    }

    public function getEmail()
    {
        return $this['email'];
    }

    public function getText()
    {
        return $this['text'];
    }

    public function getRating()
    {
        return $this['rating'];
    }

    public function getProductId()
    {
        return $this['product_id'];
    }

    public function getProduct()
    {
        if ($productId = $this['product_id']) {
            $this->_product->load($productId);
        } else {
            $this->_product->save();
            $this['product_id'] = $this->_product->getId();
            $this->save();
        }
        return $this->_product;
    }

    public function belongsToProduct(Product $product)
    {
        return $this->getProductId() == $product->getId();
    }

    public function save(IResourceEntity $resource = null)
    {
        if (!$resource) {
            $resource = $this->_resource;
        }
        $id = $resource->save($this->_data);
        $this->_data['review_id'] = $id;
    }
}
