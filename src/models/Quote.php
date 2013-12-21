<?php
namespace App\Model;

use App\Model\Resource\IResourceCollection;
use App\Model\Resource\IResourceEntity;
use App\Model\Customer;
use App\Model\QuoteItem;
use App\Model\Resource\Table\QuoteItem as QuoteItemTable;
use Test\Model\QuoteTest;

class Quote
{
    private $_customer;
    private $_session;
    private $_itemsResource;
    private $_data;
    private $_address;

    public function __construct(IResourceCollection $itemsResource = null, $data = [], Address $address = null)
    {
        $this->_itemsResource = $itemsResource;
        $this->_data = $data;
        $this->_address = $address;
    }

    public function addItemForProduct(Product $product, IResourceEntity $itemResource)
    {
        $existItem = $this->getItemForProduct($product);

        if ($existItem) {
            $existItem->addQuantity(1);
            $existItem->save($itemResource);
        } else {
            $newItemInfo = [
                'product_id' => $product->getId(),
                'quantity' => 1
            ];
            if ($this->_customer) {
                $newItemInfo['customer_id'] = $this->_customer->getId();
            } else if ($this->_session) {
                $newItemInfo['session_id'] = $this->_session->getSessionId();
            } else {
                return false;
            }
            $newItem = new QuoteItem($newItemInfo, $itemResource);
            $newItem->save($itemResource);
        }
    }

    public function getItemForProduct(Product $product)
    {

        $this->_itemsResource->filterBy('product_id', $product->getId());
        if ($this->_customer) {
            $this->_itemsResource->filterBy('customer_id', $this->_customer->getId());
        } else if ($this->_session) {
            $this->_itemsResource->filterBy('session_id', $this->_session->getSessionId());
        }

        $item = reset($this->_itemsResource->fetch());
        if ($item) {
            return new QuoteItem($item);
        } else {
            return false;
        }
    }

    public function getItemsForUser()
    {
        if ($this->_customer) {
            $this->_itemsResource->filterBy('customer_id', $this->_customer->getId());
        } else if ($this->_session) {
            $this->_itemsResource->filterBy('session_id', $this->_session->getSessionId());
        }

        return array_map(function ($item) {
            return new QuoteItem($item);
        }, $this->_itemsResource->fetch());

    }

    public function loadByCustomer(Customer $customer)
    {
        $this->_customer = $customer;
    }

    public function loadBySession(Session $session)
    {
        $this->_session = $session;
    }

    public function removeItem(QuoteItem $quoteItem, IResourceEntity $resource)
    {
        $resource->remove($quoteItem->getId());
    }

    public function getAddress()
    {

        if ($addressId = $this->_data['address_id']) {
            $this->_address->load($this->_data['address_id']);
        } else {
            $this->_address->save();
            $this->_assignAddress();

        }
        return $this->_address;
    }

    protected function _assignAddress()
    {
        $this->_data['address_id'] = $this->_address->getId();
        $this->save();
    }
}
