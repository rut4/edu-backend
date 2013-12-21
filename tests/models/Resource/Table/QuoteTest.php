<?php
namespace Test\Model\Resource\Table;

use App\Model\Resource\Table\Quote;

class QuoteTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsQuoteTableName()
    {
        $table = new Quote;
        $this->assertEquals('quotes', $table->getName());
    }

    public function testReturnsQuotePrimaryKey()
    {
        $table = new Quote;
        $this->assertEquals('quote_id', $table->getPrimaryKey());
    }
}
