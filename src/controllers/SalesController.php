<?php
namespace App\Controller;

class SalesController
extends ActionController
{

    protected function _initQuote()
    {
        $quote   = $this->_di->get('Quote');
        $session = $this->_di->get('Session');

        $quote->loadBySession($session);

        return $quote;
    }
}

