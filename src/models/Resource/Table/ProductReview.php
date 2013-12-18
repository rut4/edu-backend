<?php
namespace App\Model\Resource\Table;
class ProductReview implements ITable
{
    public function getName()
    {
        return 'product_reviews';
    }

    public function getPrimaryKey()
    {
        return 'review_id';
    }
}
  