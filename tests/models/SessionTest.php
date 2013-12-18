<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 16.12.13
 * Time: 19:26
 */

namespace Test\Model;


class SessionTest extends \PHPUnit_Framework_TestCase
{
    public function testGeneratesRandomToken()
    {
        $session = $this->getMockBuilder('App\Model\Session')
            ->disableOriginalConstructor()
            ->setMethods(['_construct'])
            ->getMock();
    }
} 