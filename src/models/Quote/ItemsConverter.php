<?php
namespace App\Model\Quote;

use App\Model\Order;
use App\Model\OrderItem;
use App\Model\Quote;
use App\Model\Session;

class ItemsConverter
    implements IConverter
{

    public function toOrder(Quote $quote, OrderItem $orderItemPrototype, Session $session, Order $order)
    {
        var_dump($order);
        $order->save();
        var_dump($order);die;
        foreach ($quote->getItems() as $quoteItem) {
            $product = $quoteItem->getProduct();
            $orderItem = clone $orderItemPrototype;

            $orderItem->setData([
                'order_id' => $order->getId(),
                'quantity' => $quoteItem->getQuantity(),
                'product_name' => $product->getName(),
                'sku' => $product->getSku(),
                'cost' => $product->isSpecialPriceApplied() ? $product->getSpecialPrice() : $product->getPrice()
            ]);
            $orderItem->save();
        }
    }
}