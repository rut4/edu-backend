<?php
namespace App\Model\Resource\Table;

class Admin
    implements ITable
{
    public function getName()
    {
        return 'admins';
    }

    public function getPrimaryKey()
    {
        return 'admin_id';
    }
}