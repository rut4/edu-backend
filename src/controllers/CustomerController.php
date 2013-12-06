<?php
namespace App\Controller;

use App\Model\ProductCollection;
use App\Model\Session;
use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;
use App\Model\Customer;
use App\Model\Resource\PDOHelper;
use App\Model\Resource\Table\Customer as CustomerTable;

class CustomerController
{
    public function loginAction()
    {
        if (isset($_POST['customer']) && $this->_authorize()) {
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
        if (isset($_POST['customer'])) {
            $this->_registerCustomer();
        } else {
            $cssName = 'customer_auth';
            $viewName = 'customer_register';
            $headerText = 'Sign Up';
            require_once __DIR__ . '/../views/layout.phtml';
        }
    }

    public function logoutAction()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['customer']);
        (new ProductController)->listAction();
    }

    private function _registerCustomer()
    {
        $connection = PDOHelper::getPdo();
        $resource = new DBEntity($connection, new CustomerTable);

        $_POST['customer']['password'] = md5($_POST['customer']['password']);

        $customer = new Customer($_POST['customer']);
        $customer->save($resource);
        new Session($customer);
        (new ProductController)->listAction();
    }

    private function _authorize()
    {
        $customers = new DBCollection(PDOHelper::getPdo(), new CustomerTable);
        $customers->filterBy('login', $_POST['customer']['login']);
        $customers->filterBy('password', md5($_POST['customer']['password']));

        $fetchedCustomers = $customers->fetch();
        if (count($fetchedCustomers) == 1) {
            $customer = new Customer(reset($fetchedCustomers));
            new Session($customer);
            return true;
        } else {
            return false;
        }
    }
}
