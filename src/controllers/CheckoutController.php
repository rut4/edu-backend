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
            $this->_redirect('checkout_shipping');
        } else {

            $city = $this->_di->get('City');
            $cityResource = $this->_di->get('ResourceCollection', ['table' => new \App\Model\Resource\Table\City]);
            $cityCollection = $this->_di->get('CityCollection', ['resource' => $cityResource, 'cityPrototype' => $city]);

            $region = $this->_di->get('Region');
            $regionResource = $this->_di->get('ResourceCollection', ['table' => new \App\Model\Resource\Table\Region]);
            $regionCollection = $this->_di->get('RegionCollection', ['resource' => $regionResource, 'regionPrototype' => $region]);

            return $this->_di->get('View', [
                'template' => 'checkout_address',
                'params' => [
                    'cities' => $cityCollection->getCities(),
                    'regions' => $regionCollection->getRegions(),
                    'header' => 'Checkout - Address',
                    'view' => 'checkout_address'
                ]
            ]);
        }
    }

    public function shippingAction()
    {
        if (isset($_POST['method_code'])) {
            $quote = $this->_initQuote();
            $quote->assignMethod($_POST['method_code']);
        } else {
            $quote = $this->_initQuote();
            $factory = $this->_di->get('Factory', ['address' => $quote->getAddress()]);

            return $this->_di->get('View', [
                'template' => 'checkout_shipping',
                'params' => [
                    'methods' => $factory->getMethods(),
                    'header' => 'Checkout - Shipping',
                    'view' => 'checkout_shipping'
                ]
            ]);
        }
    }
}
