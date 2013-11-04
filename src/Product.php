<?php

require_once __DIR__ . '/../src/CollectionElement.php';

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

    public function isSpecialPriceApplied()
    {
        return (bool)$this->getSpecialPrice();
    }
}
