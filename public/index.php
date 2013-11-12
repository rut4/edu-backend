<?php
require_once __DIR__ . '/../src/controllers/ProductController.php';
require_once __DIR__ . '/../src/models/Router.php';
require_once __DIR__ . '/../src/models/PageNotFoundException.php';
// ini_set('display_errors', 1);
try {
    try {
        $router = new Router($_GET['page']);
    } catch (PageNotFoundException $ex) {
        $router = new Router('error_pageNotFound');
    } finally {
        $controllerName = $router->getController();
        require_once __DIR__ . "/../src/controllers/{$controllerName}.php";

        $controller = new $controllerName;

        $actionName = $router->getAction();

        $controller->$actionName();
    }
} catch (Exception $ex) {
    var_dump($ex);
}

