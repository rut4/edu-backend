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

    public function getAverangeRating()
    {
        $sum = 0;

        foreach ($this->_collection as $review) {
            $sum += $review->getRating();
        }

        return $sum === 0 ? $sum : $sum/count($this->_collection);
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
