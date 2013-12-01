<?php
require_once __DIR__ . '/EntityCollection.php';
require_once __DIR__ . '/Product.php';
require_once __DIR__ . '/ProductReview.php';

class __ProductReviewCollection
    extends EntityCollection
{
    private $_productFilter;

    public function getReviews()
    {
        $reviews = $this->_getEntities();
        return $this->_applyProductFilter($reviews);
    }

    public function getAverageRating()
    {
        $ratings = array_map(function (ProductReview $review) {
            return $review->getRating();
        }, $this->getReviews());

        return array_sum($ratings) / count($ratings);
    }

    public function filterByProduct(Product $product)
    {
        $this->_productFilter = $product;
    }

    private function _applyProductFilter(array $reviews)
    {
        if (!$this->_productFilter) {
            return $reviews;
        }

        return array_filter($reviews, function (ProductReview $review) {
            return $review->belongsToProduct($this->_productFilter);
        });
    }
}