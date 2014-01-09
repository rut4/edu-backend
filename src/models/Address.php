<?php
namespace App\Model;

use App\Model\Resource\IResourceEntity;

class Address extends CollectionElement
{
    public function getCity(IResourceEntity $cityResource)
    {
        return $cityResource->find($this['city_id']);
    }

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