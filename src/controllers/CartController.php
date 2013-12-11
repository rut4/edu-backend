<?php
namespace App\Controller;

use App\Model\Product;
use App\Model\Quote;
use App\Model\QuoteItemCollection;
use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;
use App\Model\Resource\PDOHelper;
use App\Model\Resource\Table\Product as ProductTable;
use App\Model\Resource\Table\QuoteItem as QuoteItemTable;
use App\Model\Session;

class CartController
{
    public function listAction()
    {
        $session = new Session;
        $resource = new DBCollection(PDOHelper::getPdo(), new QuoteItemTable);

        $productResource = new DBEntity(PDOHelper::getPdo(), new ProductTable);

        $quote = new Quote($resource);
        if ($session->isLoggedIn()) {
            $quote->loadByCustomer($session->getCustomer());
        } else {
            $quote->loadBySession($session);
        }
        $quoteItemsByUser = $quote->getItemsForUser();

        $viewName = 'cart_list';
        $headerText = 'Shopping Cart';

        require_once __DIR__ . '/../views/layout.phtml';
    }

    public function changeCountAction()
    {
        $session = new Session;
        $resource = new DBCollection(PDOHelper::getPdo(), new QuoteItemTable);
        $productResource = new DBEntity(PDOHelper::getPdo(), new ProductTable);

        $quote = new Quote($resource);
        if ($session->isLoggedIn()) {
            $quote->loadByCustomer($session->getCustomer());
        } else {
            $quote->loadBySession($session);
        }
        $product = new \App\Model\Product;
        $product->load($productResource, $_POST['product_id']);

        $quoteItemResource = new DBEntity(PDOHelper::getPdo(), new QuoteItemTable);
        $quoteItem = $quote->getItemForProduct($product);
        if ($_POST['action'] == 'Add') {
            $quoteItem->addQuantity($_POST['count']);
        } else {
            $quoteItem->deleteQuantity($_POST['count']);
        }

        if ($quoteItem->getQuantity() == 0) {
            $quote->removeItem($quoteItem, $quoteItemResource);
        } else {
            $quoteItem->save($quoteItemResource);
        }
        $this->listAction();
    }

    public function addToCartAction()
    {
        if (isset($_POST['product_id'])) {
            $product = new Product;
            $productResource = new DBEntity(PDOHelper::getPdo(), new ProductTable);
            $product->load($productResource, $_POST['product_id']);

            $session = new Session;
            $resource = new DBCollection(PDOHelper::getPdo(), new QuoteItemTable);
            $quote = new Quote($resource);
            if ($session->isLoggedIn()) {
                $quote->loadByCustomer($session->getCustomer());
            } else {
                $quote->loadBySession($session);
            }
            $quote->addItemForProduct($product, new DBEntity(PDOHelper::getPdo(), new QuoteItemTable));
        }
        (new ProductController)->listAction();
    }
}