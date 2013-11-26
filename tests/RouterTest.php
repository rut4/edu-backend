<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 07.11.13
 * Time: 19:53
 */

require_once __DIR__ . '/../src/models/Router.php';
require_once __DIR__ . '/../src/models/PageNotFoundException.php';

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

    /**
     * @expectedException PageNotFoundException
     * @expectedExceptionMessage Expected controller and actions names are separated by '_'
     */
    public function testReturnsPageNotFoundWhenPageDoesNotContainsTwoWordsFirst()
    {
        new Router('ee_E_e');
    }

    /**
     * @expectedException PageNotFoundException
     * @expectedExceptionMessage Expected controller and actions names are separated by '_'
     */
    public function testReturnsPageNotFoundWhenPageDoesNotContainsTwoWordsSecond()
    {
        new Router('asdsa');
    }

    public function testTransformsFirstCharacterOfControllerNameToUppercase()
    {
        $router = new Router('foo_bar');
        $this->assertEquals(
            'FooController', $router->getController()
        );
    }

    public function testTransformsFirstCharacterOfActionToLowercase()
    {
        $router = new Router('foo_Bar');
        $this->assertEquals('barAction',$router->getAction());
    }

    /**
     *
     * @expectedException RouterException
     * @expectedExceptionMessage Invalid route path
     */
    public function testThrowsExceptionIfRouteIsInvalid()
    {
        $router = new Router('foo');
    }
}
