<?php
namespace App\Model\Resource\Table;

class Region
    implements ITable
{
    public function getName()
    {
        return 'regions';
    }

    public function getPrimaryKey()
    {
        return 'region_id';
    }
}
  