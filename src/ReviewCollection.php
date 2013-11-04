<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 31.10.13
 * Time: 23:27
 */

require_once __DIR__ . '/../src/Collection.php';

class ReviewCollection extends Collection
{
    public function getReviews()
    {
        return parent::getCollection();
    }

    public function getAverangeRating($product = null)
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

    public function reviewsBelongsProduct($product)
    {
        foreach ($this->_collection as $review) {
            if ($review->belongsToProduct($product)) {
                yield $review;
            }
        }
    }
}
