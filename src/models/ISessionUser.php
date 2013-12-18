<?php
namespace App\Model;

interface ISessionUser
{
    public function setSession(Session $session);
}