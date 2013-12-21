<?php
namespace App\Model\Resource\Table;
class Quote implements ITable
{
    public function getName()
    {
        return 'quotes';
    }

    public function getPrimaryKey()
    {
        return 'quote_id';
    }
}
  