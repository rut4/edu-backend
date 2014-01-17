<?php
namespace App\Model;

use App\Model\Resource\IResourceCollection;
use App\Model\Resource\IResourceEntity;
use App\Model\Customer;
use App\Model\QuoteItem;
use App\Model\Resource\Table\QuoteItem as QuoteItemTable;
use App\Model\Shipping\IMethod;
use Test\Model\QuoteTest;

class Quote extends CollectionElement
{
    private $_items;
    private $_address;
    private $_collectorsFactory;
    private $_customer;

    public function __construct(
        array $data = [],
        Resource\IResourceEntity $resource = null,
        QuoteItemCollection $items = null,
        Address $address = null,
        Quote\CollectorsFactory $collectorsFactory = null
    )
    {
        $this->_items = $items;
        $this->_address = $address;
        $this->_collectorsFactory = $collectorsFactory;
        parent::__construct($data, $resource);
    }

    public function loadBySession(Session $session)
    {

        if ($quoteId = $session->getQuoteId()) {
            $this->load($session->getQuoteId());
        } else {
            $this->save();
            $session->setQuoteId($this->getId());
        }
    }

    public function getItems()
    {
        $this->_items->filterByQuote($this);

        return $this->_items;
    }

    public function getAddress()
    {
        if ($addressId = $this['address_id']) {
            $this->_address->load($this['address_id']);
        } else {
            $this->_address->save();
            $this->_assignAddress();
        }
        return $this->_address;
    }

    public function assignShippingMethod($code)
    {
        $this->_data['shipping_method_code'] = $code;
        $this->save();
    }

    public function getShippingMethodCode()
    {
        return isset($this['shipping_method_code']) ? $this['shipping_method_code'] : null;
    }

    public function assignPaymentMethod($code)
    {
        $this->_data['payment_method_code'] = $code;
        $this->save();
    }


    public function getPaymentMethodCode()
    {
        return isset($this['payment_method_code']) ? $this['payment_method_code'] : null;
    }

    public function collectTotals()
    {
        foreach ($this->_collectorsFactory->getCollectors() as $field => $collector) {
            $this->_data[$field] = $collector->collect($this);
        }
    }

    public function getSubtotal()
    {
        return $this['subtotal'];
    }

    public function getShipping()
    {
        return $this['shipping'];
    }

    public function getGrandTotal()
    {
        return $this['grand_total'];
    }

    protected function _assignAddress()
    {
        $this->_data['address_id'] = $this->_address->getId();
        $this->save();
    }
}
