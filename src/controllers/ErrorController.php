<?php
namespace App\Controller;

class ErrorController
{
    private $_di;

    public function __construct(\Zend\Di\Di $di)
    {
        $this->_di = $di;
    }

    public function pageNotFoundAction()
    {
        return $this->_di->get('View',
        [
            'layout' => 'page_not_found',
            'template' => 'page_not_found',
            'params' => []
        ]);
    }
} 