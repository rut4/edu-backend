<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 07.11.13
 * Time: 19:53
 */

require_once __DIR__ . '/../src/models/Router.php';
require_once __DIR__ .'/../src/models/PageNotFoundException.php';

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
        try {
            $router = new Router('ee_E_e');
        } catch (PageNotFoundException $ex) {
            $this->assertEquals(
                new PageNotFoundException("Expected controller and actions names are separated by '_'"), $ex);
        }

        try {
            $router = new Router('asddsa');
        } catch (PageNotFoundException $ex) {
            $this->assertEquals(
                new PageNotFoundException("Expected controller and actions names are separated by '_'"), $ex);
        }
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

    public function testThrowPageNotFoundExceptionWhenControllerFileNotFound()
    {
        try {
            $router = new Router('products_foo');
        } catch (PageNotFoundException $ex) {
            $this->assertEquals(new PageNotFoundException('Controller file is not found'), $ex);
        }

        try {
            $router = new Router('bar_view');
        } catch (PageNotFoundException $ex) {
            $this->assertEquals(new PageNotFoundException('Controller file is not found'), $ex);
        }
    }

    /**
     * @expectedException PageNotFoundException
     * @expectedExceptionMessage Class or method are not found in file
     */
    public function testThrowPageNotFoundExceptionWhenActionNotFound()
    {
        $router = new Router('product_foo');

        $router = new Router('product_main');
    }
}
