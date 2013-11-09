<?php

require_once __DIR__ . '/../models/ProductCollection.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/ReviewCollection.php';
require_once __DIR__ . '/../models/Review.php';

class ProductController
{
    public function listAction()
    {
        $products = new ProductCollection([
            new Product([
                'image'         => 'http://www.ixbt.com/short/images/2013/Aug/Nokia-Bandit-phablet-to-be-called-Nokia-Lumia-1520.jpg',
                'name'          => 'Nokia',
                'sku'           => '1231241241234234',
                'price'         => 1000,
                'special_price' => 99.99
            ]),
            new Product([
                'image'         => 'http://www.ixbt.com/short/images/2013/Aug/Nokia-Bandit-phablet-to-be-called-Nokia-Lumia-1520.jpg',
                'name'          => 'Nokia',
                'sku'           => '1231241241234234',
                'price'         => 1000,
                'special_price' => 99.99
            ]),
            new Product([
                'image'         => 'http://www.ixbt.com/short/images/2013/Aug/Nokia-Bandit-phablet-to-be-called-Nokia-Lumia-1520.jpg',
                'name'          => 'Nokia',
                'sku'           => '1231241241234234',
                'price'         => 1000,
                'special_price' => 99.99
            ]),
            new Product([
                'image'         => 'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTGEtrv0AMdgS88Y1e7G0Fr9XWzFKQvOmRjklDmbFvvG0VBi73Z',
                'name'          => 'Samsung',
                'sku'           => '12312412123123',
                'price'         => 1000
            ]),
            new Product([
                'image'         => 'http://www.ixbt.com/short/images/2013/Aug/Nokia-Bandit-phablet-to-be-called-Nokia-Lumia-1520.jpg',
                'name'          => 'Nokia',
                'sku'           => '12312412409094',
                'price'         => 1000
            ])
        ]);

        $headerText = 'Our Product List';
        $viewName = 'product_list';
        require_once __DIR__ . '/../views/product_layout.phtml';
    }
    public function viewAction()
    {
        $product = new Product([
            'image'         => 'http://www.ixbt.com/short/images/2013/Aug/Nokia-Bandit-phablet-to-be-called-Nokia-Lumia-1520.jpg',
            'name'          => 'Nokia',
            'sku'           => '1231241241234234',
            'price'         => 1000,
            'special_price' => 99.99
        ]);

        $reviews = new ReviewCollection([
            new Review([
                'name' => 'Vasya',
                'text' => 'nice thing',
                'rating' => 5,
                'product' => $product
            ]),
            new Review([
                'name' => 'Petr',
                'text' => 'awful',
                'rating' => 2,
                'product' => $product
            ]),
            new Review([
                'name' => 'Igor',
                'text' => 'good',
                'rating' => 4,
                'product' => $product
            ])
        ]);

        $headerText = 'Product View';
        $viewName = 'product_view';
        require_once __DIR__ . '/../views/product_layout.phtml';
    }
}