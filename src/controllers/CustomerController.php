<?php
namespace App\Controller;

use App\Model\QuoteItem;
use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;
use App\Model\Resource\PDOHelper;
use App\Model\Resource\Table\QuoteItem as QuoteItemTable;
use \App\Model\Session;
use \App\Model\Customer;


class CustomerController
{
    private $_di;

    public function __construct(\Zend\Di\Di $di)
    {
        $this->_di = $di;
    }

    public function loginAction()
    {

        if (isset($_POST['customer'])) {
            $customer = $this->_di->get('Customer', ['data' => $_POST['customer']]);
            if ($this->_auth($customer)) {
                return (new ProductController($this->_di))->listAction();
            }
        } else {
            return $this->_di->get('View',
                [
                    'template' => 'customer_login',
                    'params' => [
                        'header' => 'Login',
                        'view' => 'customer_login',
                        'css' => 'customer_auth'
                    ]
                ]);
        }
    }

    public function registerAction()
    {
        $session = $this->_di->get('Session');
        if ($session->isLoggedIn()) {
            return (new ProductController($this->_di))->listAction();
        }

        if (isset($_POST['customer']) && $session->register($_POST['customer'])) {
            return $this->loginAction();
        } else {
            return $this->_di->get('View',
                [
                    'template' => 'customer_register',
                    'params' => [
                        'header' => 'Sign Up',
                        'view' => 'customer_register',
                        'css' => 'customer_auth'
                    ]
                ]);
        }
    }

    public function logoutAction()
    {
        $session = $this->_di->get('Session');
        $session->logout();
        return (new ProductController($this->_di))->listAction();
    }

    private function _auth(Customer $customer)
    {
        $session = $this->_di->get('Session');
        if ($session->auth($customer)) {
            $this->_loadProductsToCustomerCart();
            return true;
        } else {
            return false;
        }
    }

    private function _loadProductsToCustomerCart()
    {
        $session = $this->_di->get('Session');
        $resource = $this->_di->get('ResourceEntity', ['table' => new QuoteItemTable]);
        $quoteResourceSsid = $this->_di->get('ResourceCollection', ['table' => new QuoteItemTable]);
        $quoteResourceSsid->filterBy('session_id', $session->getSessionId());

        foreach ($quoteResourceSsid->fetch() as $quoteItem) {

            $quoteResource = $this->_di->get('ResourceCollection', ['table' => new QuoteItemTable]);
            $quoteResource->filterBy('customer_id', $session->getCustomer()->getId());
            $quoteResource->filterBy('product_id', $quoteItem['product_id']);
            $existItem = reset($quoteResource->fetch());

            if ($existItem) {
                $newItem = $this->_di->get('QuoteItem', ['data' => $existItem, 'resource' => $resource]);
                $newItem->addQuantity($existItem['quantity']);
                $resource->remove($quoteItem['quote_item_id']);
                $newItem->save();
            } else {
                $quoteItem['customer_id'] = $session->getCustomer()->getId();
                $quoteItem['session_id'] = null;
                // $newItem = $this->_di->get('QuoteItem', ['data' => $quoteItem]);
                  $newItem = new QuoteItem($quoteItem);
                $newItem->save($resource);
            }
        }
    }


}
