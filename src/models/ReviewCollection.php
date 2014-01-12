<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 31.10.13
 * Time: 23:27
 */

namespace App\Model;

class ReviewCollection
    implements \IteratorAggregate
{
    private $_resource;

    public function __construct(Resource\IResourceCollection $resource)
    {
        $this->_resource = $resource;
    }

    public function getReviews()
    {
        return array_map(
            function ($data) {
                return new Review($data);
            },
            $this->_resource->fetch()
        );
    }

    public function getAverageRating()
    {
        return $this->_resource->average('rating');
    }

    public function filterByProduct(Product $product)
    {
        $this->_resource->filterBy('product_id', $product->getId());
    }

    public function filterBy($field, $value)
    {
        $this->_resource->filterBy($field, $value);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getReviews());
    }
}
