<?php
namespace App\Model\Resource\Table;

class Address
    implements ITable
{
    public function getName()
    {
        return 'addresses';
    }

    public function getPrimaryKey()
    {
        return 'address_id';
    }
}
  