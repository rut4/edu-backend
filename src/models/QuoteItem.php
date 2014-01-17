<?php
namespace App\Model;

use App\Model\Resource\IResourceEntity;

class QuoteItem
    extends CollectionElement
{
    private $_product;

    public function __construct($data = [], Resource\IResourceEntity $addressResource = null, Product $product = null)
    {
        $this->_product = $product;
        parent::__construct($data, $addressResource);
    }

    public function getId()
    {
        return $this['quote_item_id'];
    }

    public function getProductId()
    {
        return $this['product_id'];
    }

    public function getCustomerId()
    {
        return $this['customer_id'];
    }

    public function getQuantity()
    {
        return $this['quantity'];
    }

    public function addQuantity($quantity)
    {
        if ($quantity > 0) {
            if (isset($this->_data['quantity'])) {
                $this->_data['quantity'] += $quantity;
            } else {
                $this->_data['quantity'] = $quantity;
            }
        }
    }

    public function deleteQuantity($quantity)
    {
        if ($quantity > 0 && $this->_data['quantity'] >= $quantity) {
            $this->_data['quantity'] -= $quantity;
        }
    }

    public function updateQuantity($quantity)
    {
        if ($quantity > 0) {
            $this->_data['quantity'] = $quantity;
        }
    }

    public function assignToQuote(Quote $quote)
    {
        $this->_data['quote_id'] = $quote->getId();
    }

    public function assignToProduct(Product $product)
    {
        $this->_data['product_id'] = $product->getId();
        $this->_product = $product;
    }

    public function belongsToProduct(Product $product)
    {
        return $this->getProductId() == $product->getId();
    }

    public function getProduct()
    {
        if (isset($this['product_id'])) {
            $this->_product->load($this->getProductId());
        }
        return $this->_product;
    }
}
