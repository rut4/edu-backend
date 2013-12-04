<?php
namespace Test\Model;

use App\Model\Router;

class RouterTest extends \PHPUnit_Framework_TestCase
{

    public function testReturnsControllerNameMatchedByRoute()
    {
        $page = 'product_list';
        $router = new Router($page);
        $this->assertEquals(
            '\App\Controller\ProductController', $router->getController()
        );

        $router = new Router('product_view');
        $this->assertEquals(
            '\App\Controller\ProductController', $router->getController()
        );

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
     * @expectedException \App\Model\PageNotFoundException
     * @expectedExceptionMessage Expected controller and actions names are separated by '_'
     */
    public function testReturnsPageNotFoundWhenPageDoesNotContainsTwoWordsFirst()
    {
        new Router('ee_E_e');
    }

    /**
     * @expectedException \App\Model\PageNotFoundException
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
            '\App\Controller\FooController', $router->getController()
        );
    }

    public function testTransformsFirstCharacterOfActionToLowercase()
    {
        $router = new Router('foo_Bar');
        $this->assertEquals('barAction',$router->getAction());
    }
}
