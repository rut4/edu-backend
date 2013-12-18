<?php
namespace App\Model;

class City extends CollectionElement
{
    public function getName()
    {
        return $this['name'];
    }

    public function getId()
    {
        return $this['city_id'];
    }

    public function getRegionId()
    {
        return $this['region_id'];
    }
}
