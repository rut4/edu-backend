<?php
namespace App\Model\Resource;

class Paginator implements \Zend\Paginator\Adapter\AdapterInterface
{
    public function __construct(\App\Model\Resource\IResourceCollection $collection)
    {
        $this->_collection = $collection;
    }

    public function getItems($offset, $itemCountPerPage)
    {
        $this->_collection->limit($itemCountPerPage, $offset);
        return $this->_collection->fetch();
    }

    public function count()
    {
        return $this->_collection->count();
    }
}