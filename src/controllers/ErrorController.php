<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 08.11.13
 * Time: 0:02
 */

class ErrorController
{
    public function pageNotFoundAction()
    {
        require_once __DIR__ . '/../views/page_not_found.phtml';
    }
} 