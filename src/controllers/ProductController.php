<?php

require_once __DIR__ . '/../models/ProductCollection.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/ReviewCollection.php';
require_once __DIR__ . '/../models/Review.php';
require_once __DIR__ . '/../models/Resource/DBCollection.php';

class ProductController
{
    public function listAction()
    {
        $connection = new PDO('mysql:host=localhost;dbname=student', 'root', 'vagrant');
        $resource = new DBCollection($connection, 'products');
        $products = new ProductCollection($resource);

        $headerText = 'Our Product List';
        $viewName = 'product_list';
        require_once __DIR__ . '/../views/product_layout.phtml';
    }
    public function viewAction()
    {
        $product = new Product();

        $connection = new PDO('mysql:host=localhost;dbname=student', 'root', 'vagrant');
        $resource = new DBEntity($connection, 'products');

        $product->load($resource);

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