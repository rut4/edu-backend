<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 31.10.13
 * Time: 23:27
 */

require_once __DIR__ . '/Collection.php';

class ReviewCollection extends Collection
{
    public function getReviews()
    {
        return parent::getCollection();
    }

    public function getAverangeRating(Product $product = null)
    {
        $count = 0;

        $ratings = array_map(function (Review $review) use ($product, &$count) {
            if (!isset($product) || $review->belongsToProduct($product)) {
                $count++;
                return $review->getRating();
            }
        }, $this->_collection);

        return $count === 0 ? 0 : array_sum($ratings) / $count;
    }

    public function reviewsBelongsProduct(Product $product)
    {
        return array_filter($this->_collection, function (Review $review) use ($product) {
            return $review->belongsToProduct($product);
        });
    }
}
