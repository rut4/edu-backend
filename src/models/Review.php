<?php

require_once __DIR__ . '/CollectionElement.php';

class Review extends CollectionElement
{
    /*
     * name
     * email
     * text
     * rating
     * product
     */

    public function __construct(array $data)
    {
        if (isset($data['rating']) && !in_array($data['rating'], [1, 2, 3, 4, 5])) {
            throw new InvalidArgumentException('Rating value mast be in range [1, 5] and integer');
        }
        parent::__construct($data);
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
}
