<?php
namespace App\Model;

class Router
{
    private $_controller;
    private $_action;

    public function __construct($route)
    {
        $arr = explode('_', $route);
        if (count($arr) != 2) {
            throw new PageNotFoundException("Expected controller and actions names are separated by '_'");
        }
        list($this->_controller, $this->_action) = $arr;
    }

    public function getController()
    {
        return '\\App\\Controller\\' . ucfirst($this->_controller) . 'Controller';
    }

    public function getAction()
    {
        return lcfirst($this->_action) . 'Action';
    }

} 