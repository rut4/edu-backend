<?php

class Product
{
    private $_data = array();

    public function __construct(array $data)
    {
        $this->_data = $data;
    }

    public function getSku()
    {
        return $this->_getData('sku');
    }

    public function getName()
    {
        return $this->_getData('name');
    }

    public function getImage()
    {
        return $this->_getData('image');
    }

    public function getPrice()
    {
        return $this->_getData('price');
    }

    public function getSpecialPrice()
    {
        return $this->_getData('special_price');
    }

    public function isSpecialPriceApplied()
    {
        return (bool) $this->getSpecialPrice();
    }

    private function _getData($key)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : null;
    }
}
