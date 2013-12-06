<?php
namespace App\Controller;

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
        return $session->auth($customer);
    }


}
