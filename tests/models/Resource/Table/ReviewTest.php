<?php
namespace Test\Model\Resource\Table;

use \App\Model\Resource\Table\Review;

class ReviewTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsProductTableName()
    {
        $table = new Review;
        $this->assertEquals('reviews', $table->getName());
    }

    public function testReturnsProductTablePrimaryKey()
    {
        $table = new Review;
        $this->assertEquals('review_id', $table->getPrimaryKey());
    }
}