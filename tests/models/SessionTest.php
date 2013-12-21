<?php

namespace Test\Model;


class SessionTest
    extends \PHPUnit_Framework_TestCase
{
    private $_session;

    public function setUp()
    {
        $this->_session = $this->getMockBuilder('App\Model\Session')
            ->disableOriginalConstructor()
            ->setMethods(['__construct'])
            ->getMock();
    }

    public function testGeneratesRandomToken()
    {
        $this->_session->generateToken();
        $tokenFoo = $this->_session->getToken();

        $this->_session->generateToken();
        $tokenBar = $this->_session->getToken();

        $this->assertNotEquals($tokenFoo, $tokenBar);
    }

    public function testValidatesTokenWithSession()
    {
        $this->_session->generateToken();
        $token = $this->_session->getToken();
        $this->assertTrue($this->_session->validateToken($token));
        $this->assertFalse($this->_session->validateToken('asdasd'));
    }

    public function testClearsTokenAfterValidation()
    {
        $this->_session = $this->getMockBuilder('App\Model\Session')
            ->disableOriginalConstructor()
            ->setMethods(['__construct'])
            ->getMock();
        $this->_session->generateToken();
        $this->_session->validateToken('123123');

        $this->assertNull($this->_session->getToken());
    }

    public function testReturnsQuoteIdIfExists()
    {
        $_SESSION['quote_id'] = 42;
        $this->assertEquals(42, $this->_session->getQuoteId());
    }

    public function testSetsQuoteIdToSession()
    {
        $this->_session->setQuoteId(42);
        $this->assertEquals(42, $_SESSION['quote_id']);
    }
}