<?php
namespace App\Controller;

use App\Model\ProductCollection;
use App\Model\ReviewCollection;
use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;
use App\Model\Product;
use App\Model\Resource\PDOHelper;
use App\Model\Resource\Table\Product as ProductTable;
use App\Model\Resource\Table\Review as ReviewTable;

class ProductController
{
    public function listAction()
    {
        $resource = new DBCollection(PDOHelper::getPdo(), new ProductTable);
        $products = new ProductCollection($resource);

        $viewName = 'product_list';
        $headerText = 'Our Product List';
        require_once __DIR__ . '/../views/product_layout.phtml';
    }

    public function viewAction()
    {
        $product = new Product([]);

        $resource = new DBEntity(PDOHelper::getPdo(), new ProductTable);
        $product->load($resource, $_GET['id']);


        $resource = new DBCollection(PDOHelper::getPdo(), new ReviewTable);
        $reviews = new ReviewCollection($resource);
        $reviews->filterByProduct($product);
        $reviews = $reviews->getReviews();

        $viewName = 'product_view';
        $headerText = 'Product View';
        require_once __DIR__ . '/../views/product_layout.phtml';
    }
}
