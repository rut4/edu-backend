<?php
namespace App\Model;

class Address extends CollectionElement
{
    public function getId()
    {
        return $this['address_id'];
    }

    public function getCityId()
    {
        return $this['city_id'];
    }

    public function getRegionId()
    {
        return $this['region_id'];
    }

    public function getPostalCode()
    {
        return $this['postal_code'];
    }

    public function getStreet()
    {
        return $this['street'];
    }

    public function getHomeNumber()
    {
        return $this['home_number'];
    }

    public function getFlat()
    {
        return $this['flat'];
    }
}
