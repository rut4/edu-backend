<?php
require_once __DIR__ . '/PageNotFoundException.php';

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
            throw new PageNotFoundException("Expected controller and actions names are separated by '_'");
        }
        list($this->_controller, $this->_action) = $arr;

        $controllerName = $this->getController();
        $actionName = $this->getAction();

        $controllerFilePath = __DIR__ . "/../controllers/{$controllerName}.php";

        if (!file_exists($controllerFilePath)) {
            throw new PageNotFoundException('Controller file is not found');
        }

        require_once $controllerFilePath;

        if (!class_exists($controllerName) || !method_exists($controllerName, $actionName)) {
            throw new PageNotFoundException('Class or method are not found in file');
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