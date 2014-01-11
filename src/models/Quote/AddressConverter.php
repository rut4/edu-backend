<?php
namespace App\Model\Quote;

use App\Model\OrderItem;
use App\Model\Session;
use App\Model\Order;
use App\Model\Quote;

class AddressConverter
    implements IConverter
{

    public function toOrder(Quote $quote, OrderItem $orderItem, Session $session, Order $order)
    {
        $address = $quote->getAddress();
        $city = $address->getCity();
        $region = $address->getRegion();
        $order->setOrderData([
            'region_name' => $region->getName(),
            'city_name' => $city->getName(),
            'postal_code' => $address->getPostalCode(),
            'street' => $address->getStreet(),
            'house_number' => $address->getHomeNumber(),
            'flat' => $address->getFlat()
        ]);
    }
}