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
    extends SalesController
{
    public function listAction()
    {
        $quote = $this->_initQuote();
        $items = $quote->getItems();
        $items->assignProducts($this->_di->get('Product'));

        return $this->_di->get('View', [
            'template' => 'cart_list',
            'params' => [
                'items' => $items,
                'header' => 'Shopping Cart',
                'view' => 'cart_list',
                'css' => 'cart_list'
            ]
        ]);
    }

    public function changeCountAction()
    {
//        $session = $this->_di->get('Session');
//        $quote = $this->_di->get('Quote');
//        $productResource = $this->_di->get('ResourceEntity', ['table' => new ProductTable]);
//        if ($session->isLoggedIn()) {
//            $quote->loadByCustomer($session->getCustomer());
//        } else {
//            $quote->loadBySession($session);
//        }
//        $product = $this->_di->get('Product', ['resource' => $productResource]);
//        $product->load($_POST['product_id']);
//
//        $quoteItemResource = $this->_di->get('ResourceEntity', ['table' => new QuoteItemTable]);
//        $quoteItem = $quote->getItemForProduct($product);
//        if ($_POST['action'] == 'Add') {
//            $quoteItem->addQuantity($_POST['count']);
//        } else {
//            $quoteItem->deleteQuantity($_POST['count']);
//        }
        $quoteItem = $this->_initQuoteItem();

        if ($_POST['action'] == 'Add') {
            $quoteItem->addQuantity($_POST['count']);
        } else {
            $quoteItem->deleteQuantity($_POST['count']);
        }

        $quoteItem->save();

        $this->_redirect('cart_list');
    }

    public function addToCartAction()
    {
        if (isset($_POST['product_id'])) {
            $quoteItem = $this->_initQuoteItem();
            $quoteItem->addQuantity(1);

            $quoteItem->save();
        }
        $this->_redirect('product_list');
    }

    private function _initQuoteItem()
    {
        $quote = $this->_initQuote();

        $product = $this->_di->get('Product');
        $product->load($_POST['product_id']);

        $item = $quote->getItems()->forProduct($product);
        return $item;
    }
}
