<?php
namespace App\Controller;

class ActionController
{
    protected  $_di;

    public function __construct(\Zend\Di\Di $di)
    {
        $this->_di = $di;
    }
}