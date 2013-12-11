<?php
namespace App\Model;

class QuoteItemCollection
    implements \IteratorAggregate
{
    private $_resource;

    public function __construct(Resource\IResourceCollection $resource)
    {
        $this->_resource = $resource;
    }

    public function getItems()
    {
        return array_map(
            function ($data) {
                return new QuoteItem($data);
            },
            $this->_resource->fetch()
        );
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getItems());
    }
}
