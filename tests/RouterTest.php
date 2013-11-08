<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 07.11.13
 * Time: 19:53
 */

require_once __DIR__ . '/../src/models/Router.php';

class RouterTest extends PHPUnit_Framework_TestCase
{

    public function testReturnsControllerNameMatchedByRoute()
    {
        $page = 'foo_bar';
        $router = new Router($page);
        $this->assertEquals('FooController', $router->getController());

        $router = new Router('product_bar');
        $this->assertEquals('ProductController', $router->getController());

    }

    public function testReturnsActionNameMatchedByRoute()
    {
        $page = 'foo_bar';
        $router = new Router($page);
        $this->assertEquals('barAction', $router->getAction());

        $router = new Router('product_baz');
        $this->assertEquals('bazAction', $router->getAction());
    }

    public  function testReturnsControllerEqualsErrorWhenWayIsNotValid()
    {
        $page = "asddsa";
        $router = new Router($page);
        $this->assertEquals('ErrorController', $router->getController());

        $page = "ee_E_e";
        $router = new Router($page);
        $this->assertEquals('ErrorController', $router->getController());
    }
}
