<?php

namespace App\Model;

use App\Model\Resource\IResourceEntity;

class Review extends CollectionElement
{
    /*
     * name
     * email
     * text
     * rating
     * product
     */

    public function __construct(array $data,  Resource\IResourceEntity $resource = null)
    {
        if (isset($data['rating']) && !in_array($data['rating'], [1, 2, 3, 4, 5])) {
            throw new \InvalidArgumentException('Rating value mast be in range [1, 5] and integer');
        }
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

    public function getProduct()
    {
        return $this['product'];
    }

    public function belongsToProduct(Product $product)
    {
        return $this->getProduct() == $product;
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
