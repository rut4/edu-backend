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
        $reviews = parent::getCollection();
        $sum = 0;

        foreach ($reviews as $review) {
            $sum += $review->getRating();
        }

        return $sum === 0 ? $sum : $sum/count($reviews);
    }
}
