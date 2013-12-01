<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 31.10.13
 * Time: 23:27
 */

require_once __DIR__ . '/Collection.php';
require_once __DIR__ . '/Review.php';

class ReviewCollection // extends Collection
    implements IteratorAggregate
{
    private $_resource;

    public function __construct(IResourceCollection $resource)
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

    public function getIterator()
    {
        return new ArrayIterator($this->getReviews());
    }
}
