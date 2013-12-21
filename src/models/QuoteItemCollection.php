<?php
namespace App\Model;

class QuoteItemCollection
    implements \IteratorAggregate
{
    private $_resource;
    private $_prototype;

    private $_items = null;

    public function __construct(Resource\IResourceCollection $resource, QuoteItem $itemPrototype)
    {
        $this->_resource = $resource;
        $this->_prototype = $itemPrototype;
    }

    public function filterByQuote(Quote $quote)
    {
        $this->_prototype->assignToQuote($quote);
        $this->_resource->filterBy('quote_id', $quote->getId());
    }

    public function getItems()
    {
        if (!$this->_items) {
            $this->_items = array_map(
                function ($data) {
                    $item = clone $this->_prototype;
                    $item->setData($data);
                    return $item;
                },
                $this->_resource->fetch()
            );
        }

        return $this->_items;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getItems());
    }

    public function forProduct(Product $product)
    {
        if ($item = $this->_findByProduct($product)) {
            return $item;
        }

        $newItem = clone $this->_prototype;
        $newItem->assignToProduct($product);
        $newItem->save();
        return $newItem;
    }

    public function assignProducts(Product $prototype)
    {
        foreach ($this as $_item) {
            $product = clone $prototype;
            $product->load($_item->getProductId());
            $_item->assignToProduct($product);
        }
    }

    private function _findByProduct(Product $product)
    {
        foreach ($this->getItems() as $_item) {
            if ($_item->belongsToProduct($product)) {
                return $_item;
            }
        }
    }
}
