<?php

class Review
{
    /*
     * name
     * email
     * text
     * rating
     * product
     */
    private $_data = array();

    public function __construct(array $data)
    {
        if (isset($data['rating']) && !in_array($data['rating'], [1, 2, 3, 4, 5])) {
            throw new InvalidArgumentException('Rating value mast be in range [1, 5] and integer');
        }
        $this->_data = $data;
    }

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

    public function getProduct()
    {
        return $this->_getData('product');
    }

    public function belongsToProduct($product)
    {
        return $this->_getData('product') === $product;
    }

    private function _getData($key)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : null;
    }
}
