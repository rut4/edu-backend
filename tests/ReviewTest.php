<?php
require_once __DIR__ . '/../src/Review.php';
require_once __DIR__ . '/../src/Product.php';

class ReviewTest extends PHPUnit_Framework_TestCase
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
        $review = new Review(['message' => 'it is good thing']);
        $this->assertEquals('it is good thing', $review->getMessage());

        $review = new Review(['message' => 'it is very awful thing']);
        $this->assertEquals('it is very awful thing', $review->getMessage());
    }

    public function testResultingRatingEqualsGivenRating()
    {
        $review = new Review(['rating' => 1]);
        $this->assertEquals(1, $review->getRating());

        $review = new Review(['rating' => 5]);
        $this->assertEquals(5, $review->getRating());
    }

    public function testResultingProductEqualsGivenProduct()
    {
        $review = new Review(['product' => new Product(['sku' => '123'])]);
        $this->assertEquals(new Product(['sku' => '123']), $review->getProduct());

        $review = new Review(['product' => new Product(['sku' => '22222', 'name' => 'Nokio'])]);
        $this->assertEquals(new Product(['sku' => '22222', 'name' => 'Nokio']), $review->getProduct());
    }
}
