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
        $sum = 0;
        $count = 0;

        foreach ($this->_collection as $review) {
            if (!isset($product) || $review->belongsToProduct($product)) {
                $sum += $review->getRating();
                $count++;
            }
        }

        return $count === 0 ? 0 : $sum/$count;
    }

    public function reviewsBelongsProduct(Product $product)
    {
        $arr = [];
        foreach ($this->_collection as $review) {
            if ($review->belongsToProduct($product)) {
                $arr[] = $review;
            }
        }
        return $arr;
    }
}
