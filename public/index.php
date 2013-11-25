<?php
require_once __DIR__ . '/../src/controllers/ProductController.php';
require_once __DIR__ . '/../src/models/Router.php';
require_once __DIR__ . '/../src/models/PageNotFoundException.php';

ini_set('display_errors', 1);

try {
    try {
        $router = new Router(isset($_GET['page']) ? $_GET['page'] : 'product_list');

        $controllerName = $router->getController();
        $actionName = $router->getAction();

        $controllerFilePath = __DIR__ . "/../src/controllers/{$controllerName}.php";


        if (!file_exists($controllerFilePath)) {
            throw new PageNotFoundException('Controller file not found');
        }

        require_once $controllerFilePath;

        if (!class_exists($controllerName) || !method_exists($controllerName, $actionName)) {
            throw new PageNotFoundException('Class or method are not exist');
        }

    } catch (PageNotFoundException $ex) {
        $controllerName = 'ErrorController';
        $actionName = 'pageNotFoundAction';
    } finally {
        require_once __DIR__ . "/../src/controllers/{$controllerName}.php";

        $controller = new $controllerName;
        $controller->$actionName();
    }
} catch (Exception $ex) {
    var_dump($ex);
}

