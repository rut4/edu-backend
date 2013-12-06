<?php
namespace App\Model;

class Session
{
    private $_customer;

    public function __construct(Customer $customer)
    {
        session_start();
        $_SESSION['customer'] = $customer;
        $this->_customer = $customer;
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['customer']) && $_SESSION['customer'] == $this->_customer;
    }

    public function getCustomer()
    {
        return $this->_customer;
    }
}