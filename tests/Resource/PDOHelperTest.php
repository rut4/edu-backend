<?php
require_once __DIR__ . '/../../src/models/Resource/PDOHelper.php';

class PDOHelperTest extends PHPUnit_Framework_TestCase
{
    public function testPdoHelperSingletonReturnsPdoObject()
    {
        $this->assertEquals(new PDO('mysql:host=localhost;dbname=student', 'root', 'vagrant'), PDOHelper::getPdo());
    }
}
