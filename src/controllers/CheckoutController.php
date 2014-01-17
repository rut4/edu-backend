<?php
namespace App\Controller;

use App\Model\ISessionUser;
use App\Model\Quote;
use App\Model\Session;

class CheckoutController
    extends SalesController
    implements ISessionUser
{

    private $_session;

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
        $quote = $this->_initQuote();
        if (isset($_POST['method_code'])) {
            $quote->assignShippingMethod($_POST['method_code']);
            $this->_redirect('checkout_payment');
        } else {
            $cityResource = $this->_di->get('ResourceEntity', ['table' => new \App\Model\Resource\Table\City]);
            $factory = $this->_di->get('ShippingFactory', ['address' => $quote->getAddress(), 'cityResource' => $cityResource]);

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

    public function paymentAction()
    {

        if (isset($_POST['method_code'])) {
            $quote = $this->_initQuote();
            $quote->assignPaymentMethod($_POST['method_code']);
            $this->_redirect('checkout_order');
        } else {
            $quote = $this->_initQuote();
            $methods = $this->_di->get('PaymentFactory')
                ->getMethods()
                ->available($quote->getAddress());

            return $this->_di->get('View', [
                'template' => 'checkout_payment',
                'params' => [
                    'methods' => $methods,
                    'header' => 'Checkout - Payment',
                    'view' => 'checkout_payment'
                ]
            ]);
        }
    }

    public function orderAction()
    {
        if (!$this->_session) {
            $session = $this->_di->get('Session');
            $this->setSession($session);
        }

        $quote = $this->_initQuote();

        if ($this->_isPost()) {
            $order = $this->_di->get('Order');
            $this->_di->get('QuoteConverter')
                ->toOrder($quote, $this->_di->get('OrderItem'), $this->_session, $order);
            $order->save();

            $smtpOptions = $this->_di->get('SmtpOptions', [
                'options' => [
                    'host' => 'smtp.yandex.ru',
                    'connection_class' => 'plain',
                    'connection_config' => [
                        'port' => 25,
                        'auth' => 'login',
                        'username' => 'vagr-ant@yandex.ru',
                        'password' => '122333221'
                    ]
                ]
            ]);

            $order->sendEmail(
                $this->_di->get('Smtp', ['options' => $smtpOptions]),
                $this->_di->get('Zend\Mail\Message'),
                $this->_session->getCustomer()
            );
        } else {
            $quote->collectTotals();
            $quote->save();
            return $this->_di->get('View', [
                'template' => 'checkout_order',
                'params' => [
                    'productsCost' => $quote->getSubtotal(),
                    'shippingCost' => $quote->getShipping(),
                    'totalCost' => $quote->getGrandTotal(),
                    'header' => 'Checkout - Order',
                    'view' => 'checkout_payment'
                ]
            ]);
        }
    }

    /**
     * @return bool
     */
    private function _isPost()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
    }

    public function setSession(Session $session)
    {
        $this->_session = $session;
    }
}
