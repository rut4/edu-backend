<?php
namespace App;

require_once __DIR__ . '/../autoloader.php';
ini_set('display_errors', 1);

try {
    try {
        $router = new Model\Router(isset($_GET['page']) ? $_GET['page'] : 'product_list');

        $controllerName = $router->getController();
        $actionName = $router->getAction();

        if (!class_exists($controllerName) || !method_exists($controllerName, $actionName)) {
            throw new Model\PageNotFoundException('Class or method are not exist');
        }

    } catch (Model\PageNotFoundException $ex) {
        $controllerName = 'ErrorController';
        $actionName = 'pageNotFoundAction';
    } finally {
        $controller = new $controllerName;
        $controller->$actionName();
    }
} catch (\Exception $ex) {
    var_dump($ex);
}

