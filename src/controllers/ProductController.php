<?php
namespace App\Controller;

use App\Model\ProductCollection;
use App\Model\Resource\Table\CartEntity as CartEntityTable;
use App\Model\ReviewCollection;
use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;
use App\Model\Product;
use App\Model\Resource\PDOHelper;
use App\Model\Resource\Table\Product as ProductTable;
use App\Model\Resource\Table\Review as ReviewTable;
use App\Model\Session;

class ProductController
{
    public function listAction()
    {
        $resource = new DBCollection(PDOHelper::getPdo(), new ProductTable);
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

    public function addToCartAction()
    {
        if (!isset($_POST['product_id'])) {
            $this->listAction();
            return;
        }
        $session = new Session;
        $cartEntity = new DBEntity(PDOHelper::getPdo(), new CartEntityTable);
        $cart = new DBCollection(PDOHelper::getPdo(), new CartEntityTable);

        if ($session->isLoggedIn()) {
            $identField = 'customer_id';
            $identValue = $session->getCustomer()->getId();
        } else {
            $identField = 'session_id';
            $identValue = session_id();
        }

        $cart->filterBy('product_id', $_POST['product_id']);
        $cart->filterBy($identField, $identValue);
        $fetchedCartEntity = $cart->fetch();

        if (count($fetchedCartEntity) == 1) {
            $preparedOrder = reset($fetchedCartEntity);
            $preparedOrder['count']++;
        } else {
            $preparedOrder = [];
            $preparedOrder['product_id'] = $_POST['product_id'];
            $preparedOrder[$identField] = $identValue;
            $preparedOrder['count'] = 1;
        }

        $cartEntity->save($preparedOrder);

        $this->listAction();
    }
}
