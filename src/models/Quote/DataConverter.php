<?php
namespace App\Model\Quote;

use App\Model\OrderItem;
use App\Model\Session;
use App\Model\Order;
use App\Model\Quote;

class DataConverter
    implements IConverter
{

    public function toOrder(Quote $quote, OrderItem $orderItem, Session $session, Order $order)
    {
        $customer = $session->getCustomer();
        $order->setOrderData([
            'customer_id' => $customer ? $customer->getId() : null,
            'shipping_method_code' => $quote->getShippingMethodCode(),
            'payment_method_code' => $quote->getPaymentMethodCode(),
            'subtotal' => $quote->getSubtotal(),
            'shipping' => $quote->getShipping(),
            'grand_total' => $quote->getGrandTotal()
        ]);
        $order->save();
    }
}