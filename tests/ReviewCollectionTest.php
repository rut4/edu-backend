<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 31.10.13
 * Time: 23:26
 */

require_once __DIR__ . '/../src/models/ReviewCollection.php';
require_once __DIR__ . '/../src/models/Review.php';

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
        $this->assertEquals(3, $reviewCollection->getAverangeRating());

        $product = new Product(['sku' => 111]);

        $reviewCollection->limit(10);
        $this->assertEquals(0, $reviewCollection->getAverangeRating($product));

        $reviewCollection = new ReviewCollection([new Review(['product' => $product, 'rating' => 5]),
            new Review(['product' => new Product(['sku' => 111]), 'rating' => 3]),
            new Review(['product' => new Product(['sku' => 555]), 'rating' => 5])]);
        $this->assertEquals(4, $reviewCollection->getAverangeRating($product));
    }

    public function testGivenProductBelongsReturnsReviews()
    {
        $product1 = new Product(['sku' => 123]);
        $product2 = new Product(['sku' => 321]);

        $expected1 = new ReviewCollection([new Review(['product' => $product1]), new Review(['product' => $product1])]);
        $expected2 = new ReviewCollection([new Review(['product' => $product2])]);

        $reviewCollection = new ReviewCollection([new Review(['product' => $product1]),
            new Review(['product' => $product2]), new Review(['product' => $product1])]);

        $this->assertEquals($expected1, $reviewCollection->reviewsBelongsProduct($product1));
        $this->assertEquals($expected2, $reviewCollection->reviewsBelongsProduct($product2));

    }
}
