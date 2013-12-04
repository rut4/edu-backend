<?php
namespace App\Model\Resource\Table;

class Review
    implements ITable
{
    public function getName()
    {
        return 'reviews';
    }

    public function getPrimaryKey()
    {
        return 'review_id';
    }
}