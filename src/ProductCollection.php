<?php

require_once __DIR__ . '/../src/Collection.php';

class ProductCollection extends Collection
{
    public function getProducts()
    {
        return parent::getCollection();
    }
}
