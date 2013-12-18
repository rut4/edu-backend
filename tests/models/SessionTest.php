<?php

namespace Test\Model;


class SessionTest
    extends \PHPUnit_Framework_TestCase
{
    public function testGeneratesRandomToken()
    {
        $session = $this->getMockBuilder('App\Model\Session')
            ->disableOriginalConstructor()
            ->setMethods(['__construct'])
            ->getMock();

        $session->generateToken();
        $tokenFoo = $session->getToken();

        $session->generateToken();
        $tokenBar = $session->getToken();

        $this->assertNotEquals($tokenFoo, $tokenBar);
    }

    public function testValidatesTokenWithSession()
    {
        $session = $this->getMockBuilder('App\Model\Session')
            ->disableOriginalConstructor()
            ->setMethods(['__construct'])
            ->getMock();

        $session->generateToken();
        $token = $session->getToken();
        $this->assertTrue($session->validateToken($token));
        $this->assertFalse($session->validateToken('asdasd'));
    }

    public function testClearsTokenAfterValidation()
    {
        $session = $this->getMockBuilder('App\Model\Session')
            ->disableOriginalConstructor()
            ->setMethods(['__construct'])
            ->getMock();
        $session->generateToken();
        $session->validateToken('123123');

        $this->assertNull($session->getToken());
    }
}