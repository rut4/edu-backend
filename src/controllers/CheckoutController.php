<?php
namespace App\Controller;

use App\Model\Quote;

class CheckoutController
    extends SalesController
{
    public function addressAction()
    {
        if (isset($_POST['address'])) {
            $quote = $this->_di->get('Quote');
            $this->_initQuote($quote);
            $address = $quote->getAddress();
            $address->setData($_POST['address']);
            $address->save();
            $this->_redirect('shipping');
        }
    }

    public function shippingAction()
    {

    }
}
