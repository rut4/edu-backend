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
        $resource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('save')
            ->will($this->returnValue(42));

        $product = new Product(['sku' => 13], $resource);

        $review = new Review([], $resource, $product);
        $this->assertTrue($product === $review->getProduct());

        $review = new Review([], $resource, new Product(['sku' => 13], $resource));
        $this->assertFalse($product === $review->getProduct());
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
        $resource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('save')
            ->will($this->returnValue(42));

        $review = new Review([], $resource, new Product(['sku' => 123], $resource));
        $this->assertTrue($review->belongsToProduct(new Product(['sku' => 123, 'product_id' => 42], $resource)));

        $review = new Review([], $resource, new Product(['name' => 'Nokio'], $resource));
        $this->assertFalse($review->belongsToProduct(new Product(['name' => 'Motorobla', 'product_id' => 42, $resource])));
    }

    public function testLoadsDataFromResource()
    {
        $resource = $this->getMock('\App\Model\Resource\IResourceEntity');
        $resource->expects($this->any())
            ->method('find')
            ->with($this->equalTo(42))
            ->will($this->returnValue(['name' => 'Vasia']));

        $productReview = new Review([], $resource);
        $productReview->load(42);

        $this->assertEquals('Vasia', $productReview->getName());
    }
}
