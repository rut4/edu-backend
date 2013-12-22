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

    public function __construct(
        array $data = [],
        Resource\IResourceEntity $resource = null,
        QuoteItemCollection $items = null,
        Address $address = null
    )
    {
        $this->_items = $items;
        $this->_address = $address;
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

    public function assignMethod($code)
    {
        $this->_data['method_code'] = $code;
        $this->save();
    }

    protected function _assignAddress()
    {
        $this->_data['address_id'] = $this->_address->getId();
        $this->save();
    }
}
