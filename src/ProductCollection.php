<?php

class ProductCollection
{
    private $_products = array();
    private $_offset = 0;
    private $_limit = 0;
    private $_count = 0;

    public function __construct(array $products)
    {
        $this->_products = $products;
        $this->_count = count($products);
        $this->_limit = $this->_count;
    }

    /*
     * @return a list of products
     */
    public function getProducts()
    {
        return array_slice($this->_products, $this->_offset, $this->_limit);
    }

    /*
     * @return size of products list
     */
    public function getSize()
    {
        return min($this->_count - $this->_offset, $this->_limit);
    }

    /*
     * set a limit for a size for out of the list
     */
    public function limit($value)
    {
       $this->_limit = min($value, $this->_count);
    }

    /*
     * set an offset for out of the list
     */
    public function offset($value)
    {
        $this->_offset = min($value, $this->_count);
    }
}