<?php
namespace App\Model;

class Admin
    extends CollectionElement
{
    public function getLogin()
    {
        return $this['login'];
    }

    public function getPassword()
    {
        return $this['password'];
    }
}
