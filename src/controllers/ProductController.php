<?php
require_once __DIR__ . '/../models/ProductCollection.php';
require_once __DIR__ . '/../models/Resource/DBCollection.php';
require_once __DIR__ . '/../models/Resource/DBEntity.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/PDOHelper.php';

class ProductController
{
    public function listAction()
    {
        $resource = new DBCollection(PDOHelper::getPdo(), 'products');
        $products = new ProductCollection($resource);

        $viewName = 'product_list';
        $headerText = 'Our Product List';
        require_once __DIR__ . '/../views/product_layout.phtml';
    }

    public function viewAction()
    {
        $product = new Product([]);

        $resource = new DBEntity(PDOHelper::getPdo(), 'products', 'product_id');
        $product->load($resource, $_GET['id']);

        $viewName = 'product_view';
        $headerText = 'Product View';
        require_once __DIR__ . '/../views/product_layout.phtml';
    }
}
