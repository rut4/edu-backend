<?php
namespace App\Model;

class CityCollection
    implements \IteratorAggregate
{
    private $_resource;
    private $_prototype;

    public function __construct(Resource\IResourceCollection $resource, City $cityPrototype)
    {
        $this->_resource = $resource;
        $this->_prototype = $cityPrototype;
    }

    public function getCities()
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
        return new \ArrayIterator($this->getCities());
    }
}
