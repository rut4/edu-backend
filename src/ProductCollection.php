<?php

class ProductCollection
{
    private $_products = array();
    private $_offset = 0;
    private $_limit = 0;

    public function __construct(array $products)
    {
        $this->_products = $products;
        $this->_limit = count($products);
    }

    public function getProducts()
    {
        return array_slice($this->_products, $this->_offset, $this->_limit);
    }

    public function getSize()
    {
        return $this->_limit;
    }

    public function limit($value)
    {
       $this->_limit = min($value, count($this->_products));
    }

    public function offset($value)
    {
        $this->_offset = $value;
    }
}