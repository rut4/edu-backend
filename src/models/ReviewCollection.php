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
    private $_product_id;

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
            !isset($this->_product_id) ? $this->_resource->fetch() :
                $this->_resource->fetchFilter('product_id', $this->_product_id)
        );
    }

    public function getAverageRating()
    {
        if (!isset($this->_product_id)) {
            return $this->_resource->fetchAvg('rating');
        } else {
            return $this->_resource->fetchAvgFilter('rating', 'product_id', $this->_product_id);
        }
    }

    public function filterByProduct(Product $product)
    {
        $this->_product_id = $product->getId();
    }

    public function getIterator()
    {
        return new ArrayIterator($this->getReviews());
    }
}
