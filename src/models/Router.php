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
        if (!isset($route) || $route === '') {
            list($this->_controller, $this->_action) = ['product', 'list'];
            return;
        }

        $arr = explode('_', $route);
        if (count($arr) != 2) {
            list($this->_controller, $this->_action) = ['error', 'pageNotFound'];
            return;
        }
        list($this->_controller, $this->_action) = $arr;

        $controllerName = $this->getController();
        $actionName = $this->getAction();

        $controllerFilePath = __DIR__ . "/../controllers/{$controllerName}.php";

        if (!file_exists($controllerFilePath)) {
            list($this->_controller, $this->_action) = ['error', 'pageNotFound'];
        } else {
            require_once $controllerFilePath;

            $controllerObject = new $controllerName;
            if (!class_exists($controllerName) || !method_exists($controllerObject, $actionName)) {
                list($this->_controller, $this->_action) = ['error', 'pageNotFound'];
            }
        }
    }

    public function getController()
    {
        return ucfirst($this->_controller) . 'Controller';
    }

    public function getAction()
    {
        return lcfirst($this->_action) . 'Action';
    }

} 