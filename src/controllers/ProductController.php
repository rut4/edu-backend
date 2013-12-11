<?php
namespace App\Controller;

use App\Model\CartHelper;
use App\Model\ProductCollection;
use App\Model\Resource\Paginator as PaginatorAdapter;
use App\Model\ReviewCollection;
use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;
use App\Model\Product;
use App\Model\Resource\PDOHelper;
use App\Model\Resource\Table\Product as ProductTable;
use App\Model\Resource\Table\Review as ReviewTable;
use Zend\Paginator\Paginator as ZendPaginator;

class ProductController
{
    public function listAction()
    {
        $resource = new DBCollection(PDOHelper::getPdo(), new ProductTable);

        $paginatorAdapter = new PaginatorAdapter($resource);
        $paginator = new ZendPaginator($paginatorAdapter);

        $paginator
            ->setItemCountPerPage(8)
            ->setCurrentPageNumber(isset($_GET['p']) ? $_GET['p'] : 1);

        $pages = $paginator->getPages();

        $products = new ProductCollection($resource);

        $viewName = 'product_list';
        $headerText = 'Our Product List';
        require_once __DIR__ . '/../views/layout.phtml';
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
        require_once __DIR__ . '/../views/layout.phtml';
    }
}
