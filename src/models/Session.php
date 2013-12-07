<?php
namespace App\Model;

use \App\Model\Resource\DBCollection;
use \App\Model\Resource\DBEntity;
use \App\Model\Resource\PDOHelper;
use \App\Model\Resource\Table\CartEntity as CartEntityTable;
use \App\Model\Resource\Table\Customer as CustomerTable;

class Session
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function register(array $customerInfo)
    {
        $resource = new DBEntity(PDOHelper::getPdo(), new CustomerTable);

        $customerInfo['password'] = md5($customerInfo['password']);
        $customer = new Customer($customerInfo);
        try {
            $customer->save($resource);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function auth(Customer $customer)
    {
        $customers = new DBCollection(PDOHelper::getPdo(), new CustomerTable);
        $customers->filterBy('login', $customer->getLogin());
        $customers->filterBy('password', md5($customer->getPassword()));

        try {
            $fetchedCustomers = $customers->fetch();
        } catch (\Exception $ex) {
            $fetchedCustomers = [];
            var_dump($ex);
        }

        if (count($fetchedCustomers) == 1) {
            $_SESSION['customer'] = new Customer(reset($fetchedCustomers));
            $this->_loadProductsToCustomerCart();
            return true;
        } else {
            return false;
        }
    }

    public function logout()
    {
        if (isset($_SESSION['customer'])) {
            unset($_SESSION['customer']);
        }

    }

    public function isLoggedIn()
    {
        return isset($_SESSION['customer']);
    }

    public function getCustomer()
    {
        return $this->isLoggedIn() ? $_SESSION['customer'] : null;
    }

    private function _loadProductsToCustomerCart()
    {
        $resource = new DBEntity(PDOHelper::getPdo(), new CartEntityTable);
        $DbCartEntities = new DBCollection(PDOHelper::getPdo(), new CartEntityTable);
        $DbCartEntities->filterBy('session_id', session_id());
        foreach ($DbCartEntities->fetch() as $fetchedCartEntity) {

            $alreadyTiedEntities = new DBCollection(PDOHelper::getPdo(), new CartEntityTable);
            $alreadyTiedEntities->filterBy('customer_id', $this->getCustomer()->getId());
            $alreadyTiedEntities->filterBy('product_id', $fetchedCartEntity['product_id']);
            $alreadyTiedEntity = reset($alreadyTiedEntities->fetch());
            if ($alreadyTiedEntity) {
                $cartEntity = new CartEntity($alreadyTiedEntity);
                $cartEntity->setCount($alreadyTiedEntity['count'] + $cartEntity->getCount());
                $cartEntity->save($resource);
            } else {
                $fetchedCartEntity['customer_id'] = $this->getCustomer()->getId();
                $fetchedCartEntity['session_id'] = null;
                $cartEntity = new CartEntity($fetchedCartEntity);
                $cartEntity->save($resource);
            }
        }
    }
}