<?php
require_once __DIR__ . '/../models/ProductCollection.php';
require_once __DIR__ . '/../models/Resource/DBCollection.php';
require_once __DIR__ . '/../models/Resource/DBEntity.php';
require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    public function listAction()
    {
        $connection = new PDO('mysql:host=localhost;dbname=student', 'root', '123123');
        $resource = new DBCollection($connection, 'products');
        $products = new ProductCollection($resource);

        require_once __DIR__ . '/../views/product_list.phtml';
    }

    public function viewAction()
    {
        $product = new Product([]);

        $connection = new PDO('mysql:host=localhost;dbname=student', 'root', '123123');
        $resource = new DBEntity($connection, 'products', 'product_id');
        $product->load($resource, $_GET['id']);

        require_once __DIR__ . '/../views/product_view.phtml';
    }
}
