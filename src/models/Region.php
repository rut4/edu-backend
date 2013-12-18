<?php
namespace App\Model;

use App\Model\Resource\IResourceEntity;

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

    public function save(IResourceEntity $resource = null)
    {
        if (!$resource) {
            $resource = $this->_resource;
        }
        $id = $resource->save($this->_data);
        $this->_data['region_id'] = $id;
    }
}
