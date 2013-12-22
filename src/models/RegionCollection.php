<?php
namespace App\Model;

class RegionCollection
    implements \IteratorAggregate
{
    private $_resource;
    private $_prototype;

    public function __construct(Resource\IResourceCollection $resource, Region $regionPrototype)
    {
        $this->_resource = $resource;
        $this->_prototype = $regionPrototype;
    }

    public function getRegions()
    {
        return array_map(
            function ($data) {
                $item = clone $this->_prototype;
                $item->setData($data);
                return $item;
            },
            $this->_resource->fetch()
        );
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getRegions());
    }
}
