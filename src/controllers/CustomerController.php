<?php
namespace App\Controller;

use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;
use App\Model\Resource\PDOHelper;
use App\Model\Resource\Table\QuoteItem as QuoteItemTable;
use \App\Model\Session;
use \App\Model\Customer;


class CustomerController
{
    public function loginAction()
    {
        if (isset($_POST['customer']) && $this->_auth(new Customer($_POST['customer']))) {
            (new ProductController)->listAction();
        } else {
            $cssName = 'customer_auth';
            $viewName = 'customer_login';
            $headerText = 'Login';
        }
        require_once __DIR__ . '/../views/layout.phtml';
    }

    public function registerAction()
    {
        $session = new Session();
        if (isset($_POST['customer']) && $session->register($_POST['customer'])) {
            $this->loginAction();
        } else {
            $cssName = 'customer_auth';
            $viewName = 'customer_register';
            $headerText = 'Sign Up';
            require_once __DIR__ . '/../views/layout.phtml';
        }
    }

    public function logoutAction()
    {
        $session = new Session();
        $session->logout();
        (new ProductController)->listAction();
    }

    private function _auth(Customer $customer)
    {
        $session = new Session();
        if ($session->auth($customer)) {
            $this->_loadProductsToCustomerCart();
            return true;
        } else {
            return false;
        }
    }

    private function _loadProductsToCustomerCart()
    {
        $session = new Session;
        $resource = new DBEntity(PDOHelper::getPdo(), new QuoteItemTable);
        $quoteResource = new DBCollection(PDOHelper::getPdo(), new QuoteItemTable);
        $quoteResource->filterBy('session_id', $session->getSessionId());

        foreach ($quoteResource->fetch() as $quoteItem) {
            $quoteResource = new DBCollection(PDOHelper::getPdo(), new QuoteItemTable);
            $quoteResource->filterBy('customer_id', $session->getCustomer()->getId());
            $quoteResource->filterBy('product_id', $quoteItem['product_id']);
            $existItem = reset($quoteResource->fetch());

            if ($existItem) {
                $newItem = new \App\Model\QuoteItem($existItem);
                $newItem->addQuantity($existItem['quantity']);
                $resource->remove($quoteItem['quote_item_id']);
                $newItem->save($resource);
            } else {
                $quoteItem['customer_id'] = $session->getCustomer()->getId();
                $quoteItem['session_id'] = null;
                $newItem = new \App\Model\QuoteItem($quoteItem);
                $newItem->save($resource);
            }
        }
    }


}
