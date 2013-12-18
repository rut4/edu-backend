<?php
namespace App\Model;

class Region extends CollectionElement
{
    public function getName()
    {
        return $this['name'];
    }

    public function getId()
    {
        return $this['region_id'];
    }
}
