<?php
namespace Test\Model;

use App\Model\ModelView;

class ModelViewTest extends \PHPUnit_Framework_TestCase
{
    public function testRendersProvidedTemplate()
    {
        $vew = new ModelView(
            $layoutDir = __DIR__. '/ModelViewTest/fixtures/layouts/',
            $templateDir = __DIR__. '/ModelViewTest/fixtures/templates/',
            $layout = 'layout',
            $template = 'template',
            $params = ['foo' => 'bar']
        );

        ob_start();
        $vew->render();
        $contents = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('<p>foo is bar</p>', $contents);
    }

    public function testReturnsProvidedSession()
    {
        $view = new ModelView(null, null, null, null, []);
        $session = $this->getMockBuilder('App\Model\Session')
            ->disableOriginalConstructor()
            ->setMethods(['__construct'])
            ->getMock();

        $view->setSession($session);
        $this->assertSame($session, $view->session());
    }
}
