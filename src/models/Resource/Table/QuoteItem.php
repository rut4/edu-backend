<?php
namespace App\Model\Resource\Table;
class QuoteItem implements ITable
{
    public function getName()
    {
        return 'quote_items';
    }

    public function getPrimaryKey()
    {
        return 'quote_item_id';
    }
}

