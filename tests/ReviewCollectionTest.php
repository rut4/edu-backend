<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 31.10.13
 * Time: 23:26
 */

require_once __DIR__ . '/../src/ReviewCollection.php';
require_once __DIR__ . '/../src/Review.php';

class ReviewCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testResultingReviewsEqualsGivenReviews()
    {
        $reviewCollection = new ReviewCollection([new Review(['name' => 'vlad']), new Review(['email' => 'f@f.ff'])]);
        $this->assertEquals([new Review(['name' => 'vlad']), new Review(['email' => 'f@f.ff'])],
            $reviewCollection->getReviews());

        $reviewCollection = new ReviewCollection([new Review(['message' => 'nice'])]);
        $this->assertEquals([new Review(['message' => 'nice'])], $reviewCollection->getReviews());
    }

    public function testResultingReviewsSizeEqualsGivenReviewsSize()
    {
        $reviewCollection = new ReviewCollection([new Review([]), new Review([])]);
        $this->assertEquals(2, $reviewCollection->getSize());

        $reviewCollection = new ReviewCollection([new Review([])]);
        $this->assertEquals(1, $reviewCollection->getSize());
    }

    public function testResultingReviewsCountMustBeEqualsOrLessGivenLimit()
    {
        $reviewCollection = new ReviewCollection([new Review([]), new Review([])]);

        $reviewCollection->limit(1);
        $this->assertEquals(1, $reviewCollection->getSize());

        $reviewCollection->limit(3);
        $this->assertEquals(2, $reviewCollection->getSize());

        $reviewCollection->limit(0);
        $this->assertEquals(0, $reviewCollection->getSize());
    }

    public function testOffsetMustBeShiftReviews()
    {
        // if offset negative shift begin with end

        $reviewCollection = new ReviewCollection([new Review(['name' => 'Vlad']), new Review(['name' => 'Igor']),
            new Review(['name' => 'Michael'])]);

        $reviewCollection->offset(1);
        $this->assertEquals([new Review(['name' => 'Igor']), new Review(['name' => 'Michael'])],
            $reviewCollection->getReviews());

        $reviewCollection->offset(3);
        $this->assertEquals([], $reviewCollection->getReviews());

        $reviewCollection->offset(-1);
        $this->assertEquals([new Review(['name' => 'Michael'])], $reviewCollection->getReviews());
    }

    public function testReturnsAverangeRatingEqualsRealAverangeRating()
    {
        $reviewCollection = new ReviewCollection([new Review(['rating' => 1]), new Review(['rating' => 3]),
            new Review(['rating' => 5])]);

        $this->assertEquals(3, $reviewCollection->getAverangeRating());

        $reviewCollection->limit(0);
        $this->assertEquals(0, $reviewCollection->getAverangeRating());
    }

    public function testGivenProductBelongsReturnsReviews()
    {
        $product1 = new Product(['sku' => 123]);
        $product2 = new Product(['sku' => 321]);

        $expected1 = [new Review(['product' => $product1]), new Review(['product' => $product1])];
        $expected2 = [new Review(['product' => $product2])];

        $reviewCollection = new ReviewCollection([new Review(['product' => $product1]),
            new Review(['product' => $product2]), new Review(['product' => $product1])]);

        $generatorObject = $reviewCollection->reviewsBelongsProduct($product1);
        foreach ($generatorObject as $review) {
            $this->assertEquals(current($expected1)->getProduct(), $review->getProduct());
            next($expected1);
        }

        $generatorObject = $reviewCollection->reviewsBelongsProduct($product2);
        foreach ($generatorObject as $review) {
            $this->assertEquals(current($expected2)->getProduct(), $review->getProduct());
            next($expected2);
        }
    }
}
