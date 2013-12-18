<?php
namespace App\Model;

class AddressCollection
    implements \IteratorAggregate
{
    private $_resource;

    public function __construct(Resource\IResourceCollection $resource)
    {
        $this->_resource = $resource;
    }

    public function getAddresses()
    {
        return array_map(
            function ($data) {
                return new Address($data);
            },
            $this->_resource->fetch()
        );
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getAddresses());
    }
}
