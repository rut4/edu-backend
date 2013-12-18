<?php
namespace App\Model;

class RegionCollection
    implements \IteratorAggregate
{
    private $_resource;

    public function __construct(Resource\IResourceCollection $resource)
    {
        $this->_resource = $resource;
    }

    public function getRegions()
    {
        return array_map(
            function ($data) {
                return new Region($data);
            },
            $this->_resource->fetch()
        );
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getRegions());
    }
}
