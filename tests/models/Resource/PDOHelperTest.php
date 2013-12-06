<?php
namespace Test\Model\Resource;
use \App\Model\Resource\PDOHelper;

class PDOHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testPdoHelperSingletonReturnsPdoObject()
    {
        $this->assertEquals(new \PDO('mysql:host=localhost;dbname=student', 'root', 'vagrant'), PDOHelper::getPdo());
    }
}
