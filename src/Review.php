<?php

class Review
{
    /*
     * username
     * email
     * message
     * rating
     * product
     */
    private $_data = array();

    public function __construct(array $data)
    {
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

    public function getMessage()
    {
        return $this->_getData('message');
    }

    public function getRating()
    {
        return $this->_getData('rating');
    }

    public function getProduct()
    {
        return $this->_getData('product');
    }

    private function _getData($key)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : null;
    }
}
