<?php
namespace App\Model;

use Zend\Mail\Storage\Message;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;

class Order
    extends CollectionElement
{
    private $_orderItemCollection;

    public function __construct(OrderItemCollection $orderItemCollection = null)
    {
        $this->_orderItemCollection = $orderItemCollection;
        parent::__construct();
    }
    public function setOrderData($data)
    {
        $this->_data = array_merge($this->_data, $data);
    }

    public function sendEmail(Customer $customer)
    {
        $messageText = "Customer ID: {$customer->getId()}\nName: {$customer->getName()}\nEmail: {$customer->getEmail()}\n\n";
        $messageText .= "Products\n";
        $this->_orderItemCollection->filterByOrder($this);
        $orderItems = $this->_orderItemCollection->getOrderItems();

        foreach($orderItems as $orderItem) {
            $messageText .= "Sku: {$orderItem['sku']}\nName: {$orderItem['product_name']}\nQuantity: {$orderItem['quantity']}\n";
            $messageText .= "Cost: {$orderItem['cost']}\n----------------------------\n";
        }

        $messageText .= "\n\nRegion: {$this['region_name']}\nCity: {$this['city_name']}\nPostal code: {$this['postal_code']}\n";
        $messageText .= "Street: {$this['street']}\nHome number: {$this['home_number']}\nFlat: {$this['flat']}\n";
        $messageText .= "Shipping method code: {$this['shipping_method_code']}\nPayment method code: {$this['payment_method_code']}\n";
        $messageText .= "Subtotal: {$this['subtotal']}\nShipping: {$this['shipping']}\nGrand total: {$this['grand_total']}\n";
        $smtpOptions = new SmtpOptions([
            'host' => 'smtp.gmail.com',
            'connection_class' => 'plain',
            'connection_config' => [
                'username' => 'vagrant@gmail.com',
                'password' => 'vagrant',
                'ssl' => 'tls'
            ]
        ]);
        $smtpTransport = new Smtp($smtpOptions);

        $message = new \Zend\Mail\Message();
        $message
            ->addTo('vagrant@gmail.com')
            ->addFrom('vagrant@gmail.com')
            ->setSubject('Order from student shop')
            ->setBody($messageText);

        $smtpTransport->send($message);


    }
}
