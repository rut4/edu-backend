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
        $page = 'product_list';
        $router = new Router($page);
        $this->assertEquals('ProductController', $router->getController());

        $router = new Router('product_view');
        $this->assertEquals('ProductController', $router->getController());

    }

    public function testReturnsActionNameMatchedByRoute()
    {
        $page = 'product_list';
        $router = new Router($page);
        $this->assertEquals('listAction', $router->getAction());

        $router = new Router('product_View');
        $this->assertEquals('viewAction', $router->getAction());
    }

    public function testReturnsPageNotFoundWhenPageDoesNotContainsTwoWords()
    {
        $page = "asddsa";
        $router = new Router($page);
        $this->assertEquals('ErrorController', $router->getController());
        $this->assertEquals('pageNotFoundAction', $router->getAction());

        $page = "ee_E_e";
        $router = new Router($page);
        $this->assertEquals('ErrorController', $router->getController());
        $this->assertEquals('pageNotFoundAction', $router->getAction());
    }

    public function testReturnsProductListPageWhenPageDoesNotSetOrEmpty()
    {
        $page = '';
        $router = new Router($page);
        $this->assertEquals('ProductController', $router->getController());
        $this->assertEquals('listAction',$router->getAction());

        $page = null;
        $router = new Router($page);
        $this->assertEquals('ProductController', $router->getController());
        $this->assertEquals('listAction',$router->getAction());
    }

    public function testReturnsPageNotFoundWhenControllerOrActionAreNotExist()
    {
        $router = new Router('product_foo');
        $this->assertEquals('ErrorController', $router->getController());
        $this->assertEquals('pageNotFoundAction', $router->getAction());

        $router = new Router('bar_view');
        $this->assertEquals('ErrorController', $router->getController());
        $this->assertEquals('pageNotFoundAction', $router->getAction());
    }
}
