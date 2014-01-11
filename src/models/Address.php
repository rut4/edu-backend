<?php
namespace App\Model;

use App\Model\Resource\IResourceEntity;

class Address extends CollectionElement
{
    private $_region;
    private $_city;

    public function __construct(Region $region = null, City $city = null)
    {
        $this->_region = $region;
        $this->_city = $city;
        parent::__construct();
    }

    public function getCity()
    {
        if (!$this->_city) {
            return null;
        }

        if (isset($this['city_id'])) {
            $this->_city->load($this['city_id']);
            return $this->_city;
        } else {
            return $this->_city;
        }
    }

    public function getRegion()
    {
        if (!$this->_region) {
            return null;
        }

        if (isset($this['region_id'])) {
            $this->_region->load($this['region_id']);
            return $this->_region;
        } else {
            return $this->_region;
        }
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