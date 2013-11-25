<?php

require_once __DIR__ . '/Collection.php';
require_once __DIR__ . '/Resource/IResourceCollection.php';

class ProductCollection // extends Collection
{
    private $_resource;

    public function __construct(IResourceCollection $resource)
    {
        $this->_resource = $resource;
    }

    public function getProducts()
    {
        // return parent::getCollection();
        return array_map(
            function ($data) {
                return new Product($data);
            },
            $this->_resource->fetch()
        );
    }
}
