<?php
require_once __DIR__ . '/../src/controllers/ProductController.php';
require_once __DIR__ . '/../src/models/Router.php';

ini_set('display_errors', 1);

$router = new Router(isset($_GET['page']) ? $_GET['page'] : 'product_list');

$controllerName = $router->getController();
require_once __DIR__ . "/../src/controllers/{$controllerName}.php";

$controller = new $controllerName;

$actionName = $router->getAction();

$controller->$actionName();