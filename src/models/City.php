<?php
namespace App\Model;

class City
    extends CollectionElement
{
    public function getName()
    {
        return $this['name'];
    }

    public function getRegionId()
    {
        return $this['region_id'];
    }

    public function getPrice()
    {
        return $this['shipping_price'];
    }
}
