<?php
namespace App\Controller;

class ErrorController
{
    public function pageNotFoundAction()
    {
        require_once __DIR__ . '/../views/page_not_found.phtml';
    }
} 