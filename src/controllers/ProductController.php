<?php
namespace App\Controller;

use App\Model\CartHelper;
use App\Model\ModelView;
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
    private $_di;

    public function __construct(\Zend\Di\Di $di)
    {
        $this->_di = $di;
    }

    public function listAction()
    {
        $resource = $this->_di->get('ResourceCollection', ['table' => new \App\Model\Resource\Table\Product]);
        $paginator = $this->_di->get('Paginator', ['collection' => $resource]);

        $paginator
            ->setItemCountPerPage(8)
            ->setCurrentPageNumber(isset($_GET['p']) ? $_GET['p'] : 1);

        $pages = $paginator->getPages();
        $currentPage = $paginator->getCurrentPageNumber();

        $products = $this->_di->get('ProductCollection', ['resource' => $resource]);

        return $this->_di->get('View', [
            'template' => 'product_list',
            'params' => [
                'products' => $products,
                'pages' => $pages,
                'header' => 'Our Product List',
                'view' => 'product_list',
                'css' => 'product_list'
            ]
        ]);

    }

    public function viewAction()
    {
        $resource = $this->_di->get('ResourceEntity', ['table' => new \App\Model\Resource\Table\Product]);
        $product = $this->_di->get('Product', ['resource' => $resource]);
        $product->load($_GET['id']);

        $reviewResource = $this->_di->get('ResourceCollection', ['table' => new \App\Model\Resource\Table\Review]);

        $reviews = $this->_di->get('ReviewCollection', ['resource' => $reviewResource]);
        $reviews->filterByProduct($product);

        $paginator = $this->_di->get('Paginator', ['collection' => $reviewResource]);

        $paginator
            ->setItemCountPerPage(2)
            ->setCurrentPageNumber(isset($_GET['p']) ? $_GET['p'] : 1);


        $pages = $paginator->getPages();

        return $this->_di->get('View', [
            'template' => 'product_view',
            'params' => [
                'product' => $product,
                'reviews' => $reviews,
                'pages' => $pages,
                'header' => 'Our Product List',
                'view' => 'product_view',
                'css' => 'product_view'
            ]
        ]);
    }
}
