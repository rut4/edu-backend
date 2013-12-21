<?php
namespace Test\Model\Resource\Table;

use App\Model\Resource\Table\QuoteItem;

class QuoteItemTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsQuoteItemTableName()
    {
        $table = new QuoteItem;
        $this->assertEquals('quote_items', $table->getName());
    }

    public function testReturnsQuoteItemPrimaryKey()
    {
        $table = new QuoteItem;
        $this->assertEquals('item_id', $table->getPrimaryKey());
    }
}
