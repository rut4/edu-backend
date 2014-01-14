<?php
namespace App\Model;

use \App\Model\Resource\DBCollection;
use \App\Model\Resource\DBEntity;
use \App\Model\Resource\PDOHelper;
use \App\Model\Resource\Table\Admin as AdminTable;
use \App\Model\Resource\Table\Customer as CustomerTable;

class Session
{
    public function __construct()
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
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

            return true;
        } else {
            return false;
        }
    }

    public function authAdmin(Admin $admin)
    {
        $admins = new DBCollection(PDOHelper::getPdo(), new AdminTable);
        $admins->filterBy('login', $admin->getLogin());
        $admins->filterBy('password', md5($admin->getPassword()));

        try {
            $fetchedAdmins = $admins->fetch();
        } catch (\Exception $ex) {
            $fetchedAdmins = [];
            var_dump($ex);
        }

        if (count($fetchedAdmins) == 1) {
            $_SESSION['admin'] = reset($fetchedAdmins);
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

    public function logoutAdmin()
    {
        if (isset($_SESSION['admin'])) {
            unset($_SESSION['admin']);
        }
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['customer']);
    }

    public function isAdminLoggedIn()
    {
        return isset($_SESSION['admin']);
    }


    public function getCustomer()
    {
        return $this->isLoggedIn() ? $_SESSION['customer'] : null;
    }

    public function getAdmin()
    {
        return $this->isAdminLoggedIn() ? $_SESSION['admin'] : null;
    }

    public function getSessionId()
    {
        return session_id();
    }

    public function generateToken()
    {
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
    }

    public function getToken()
    {
        return isset($_SESSION['token']) ? $_SESSION['token'] : null;
    }

    public function validateToken($token)
    {
        $valid = $this->getToken() === $token;
        unset($_SESSION['token']);
        return $valid;
    }

    public function getQuoteId()
    {
        return isset($_SESSION['quote_id']) ? $_SESSION['quote_id'] : null;
    }

    public function setQuoteId($id)
    {
        $_SESSION['quote_id'] = $id;
    }
}