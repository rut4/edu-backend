<?php
namespace App\Model;

use \App\Model\Resource\IResourceEntity;

class Customer extends CollectionElement
{
    public function save(IResourceEntity $resource)
    {
        $id = $resource->save($this->_data);
        $this->_data['customer_id'] = $id;
    }

    public function getId()
    {
        return $this['customer_id'];
    }

    public function getEmail()
    {
        return $this['email'];
    }

    public function getName()
    {
        return $this['name'];
    }

    public function getLogin()
    {
        return $this['login'];
    }

    public function getPassword()
    {
        return $this['password'];
    }
}
