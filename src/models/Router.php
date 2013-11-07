<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 07.11.13
 * Time: 19:55
 */

class Router
{
    private $_controller;
    private $_action;

    public function __construct($route)
    {
        list($this->_controller, $this->_action) = explode('_', $route);

    }

    public function getController()
    {
        return ucfirst($this->_controller) . 'Controller';
    }

    public function getAction()
    {
        return $this->_action . 'Action';
    }

} 