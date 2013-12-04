<?php
namespace Test\Model;

use \App\Model\Review;
use \App\Model\Product;

class ReviewTest extends \PHPUnit_Framework_TestCase
{
    public function testResultingUsernameEqualsGivenUsername()
    {
        $review = new Review(['name' => 'Vasya']);
        $this->assertEquals('Vasya', $review->getName());

        $review = new Review(['name' => 'Petr']);
        $this->assertEquals('Petr', $review->getName());
    }

    public function testResultingEmailEqualsGivenEmail()
    {
        $review = new Review(['email' => 'a@a.ru']);
        $this->assertEquals('a@a.ru', $review->getEmail());

        $review = new Review(['email' => 'fff@gmail.com']);
        $this->assertEquals('fff@gmail.com', $review->getEmail());
    }

    public function testResultingMessageEqualsGivenMessage()
    {
        $review = new Review(['text' => 'it is good thing']);
        $this->assertEquals('it is good thing', $review->getText());

        $review = new Review(['text' => 'it is very awful thing']);
        $this->assertEquals('it is very awful thing', $review->getText());
    }

    public function testResultingRatingEqualsGivenRating()
    {
        $review = new Review(['rating' => 1]);
        $this->assertEquals(1, $review->getRating());

        $review = new Review(['rating' => 5]);
        $this->assertEquals(5, $review->getRating());
    }

    public function testReturnsProductEqualsGivenProduct()
    {
        $product = new Product(['sku' => 13]);

        $review = new Review(['product' => $product]);
        $this->assertEquals(true, $product === $review->getProduct());

        $review = new Review(['product' => new Product(['sku' => 13])]);
        $this->assertEquals(false, $product === $review->getProduct());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Rating value mast be in range [1, 5] and integer
     */
    public function testGivenRatingMustBeFromOneToFive()
    {
        new Review(['rating' => 0]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Rating value mast be in range [1, 5] and integer
     */
    public function testGivenRatingMustBeInteger()
    {
        new Review(['rating' => 1.5]);
    }

    public function testReturnsTrueIfReviewBelongsToProduct()
    {
        $review = new Review(['product' => new Product(['sku' => 123])]);
        $this->assertEquals(true, $review->belongsToProduct(new Product(['sku' => 123])));

        $review = new Review(['product' => new Product(['name' => 'Nokio'])]);
        $this->assertEquals(false, $review->belongsToProduct(new Product(['name' => 'Motorobla'])));
    }

    public function testLoadsDataFromResource()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('find')
            ->with($this->equalTo(42))
            ->will($this->returnValue(['name' => 'Vasia']));

        $productReview = new Review([]);
        $productReview->load($resource, 42);

        $this->assertEquals('Vasia', $productReview->getName());
    }
}
