<?php

namespace App\Model;

use App\Model\Resource\PDOHelper;
use Zend\Stdlib\Hydrator\Reflection;

class DiC
{
    private $_di;
    private $_im;

    public function __construct(\Zend\Di\Di $di)
    {
        $this->_di = $di;
        $this->_im = $di->instanceManager();
    }

    public function assemble()
    {
        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PRIVATE) as $_method) {
            if (strpos($_method->getName(), '_assemble') === 0) {
                $_method->setAccessible(true);
                $_method->invoke($this);
            }
        }


    }

    private function _assembleDbConnection()
    {
        $this->_im->setParameters('App\Model\Resource\DBCollection', ['connection' => PDOHelper::getPdo()]);
        $this->_im->setParameters('App\Model\Resource\DBEntity', ['connection' => PDOHelper::getPdo()]);
    }

    private function _assemblePaginator()
    {
        $this->_im->setParameters('Zend\Paginator\Paginator', ['adapter' => 'App\Model\Resource\Paginator']);
        $this->_im->addAlias('Paginator', 'Zend\Paginator\Paginator');
    }

    private function _assembleResources()
    {
        $this->_im->addTypePreference('App\Model\Resource\IResourceCollection', 'App\Model\Resource\DBCollection');
        $this->_im->addTypePreference('App\Model\Resource\IResourceEntity', 'App\Model\Resource\DBEntity');
        $this->_im->addAlias('ResourceCollection', 'App\Model\Resource\DBCollection');
        $this->_im->addAlias('ResourceEntity', 'App\Model\Resource\DBEntity');

        $this->_im->setShared('App\Model\Resource\DBEntity', false);
        $this->_im->setShared('App\Model\Resource\DBCollection', false);
    }

    private function _assembleProduct()
    {
        $this->_im->setParameters('App\Model\ProductCollection', ['table' => 'App\Model\Resource\Table\Product']);
        $this->_im->addAlias('ProductCollection', 'App\Model\ProductCollection');

        $this->_im->setParameters('App\Model\Product', ['table' => 'App\Model\Resource\Table\Product']);
        $this->_im->addAlias('Product', 'App\Model\Product');
    }

    private function _assembleReview()
    {
        $this->_im->setParameters('App\Model\ReviewCollection', ['table' => 'App\Model\Resource\Table\Review']);
        $this->_im->addAlias('ReviewCollection', 'App\Model\ReviewCollection');

        $this->_im->setParameters('App\Model\Review', [
            'table' => 'App\Model\Resource\Table\Review',
            'product' => $this->_di->get('App\Model\Product')
        ]);
        $this->_im->addAlias('Review', 'App\Model\Review');

        $this->_im->addAlias('ReviewTable', 'App\Model\Resource\Table\Review');
    }

    private function _assembleQuoteItem()
    {
        $this->_im->setParameters('App\Model\QuoteItem', [
            'table' => 'App\Model\Resource\Table\QuoteItem',
            'product' => $this->_di->get('App\Model\Product')
        ]);

        $this->_im->addAlias('QuoteItem', 'App\Model\QuoteItem');

        $this->_im->setParameters('App\Model\QuoteItemCollection', [
            'table' => 'App\Model\Resource\Table\QuoteItem',
            'itemPrototype' => $this->_di->get('App\Model\QuoteItem')
        ]);
        $this->_im->addAlias('QuoteItemCollection', 'App\Model\QuoteItemCollection');
    }

    private function _assembleOrderItem()
    {
        $this->_im->setParameters('App\Model\OrderItem', ['table' => 'App\Model\Resource\Table\OrderItem']);
        $this->_im->addAlias('OrderItem', 'App\Model\OrderItem');

        $this->_im->setParameters('App\Model\OrderItemCollection', ['table' => 'App\Model\Resource\Table\OrderItem']);
        $this->_im->addAlias('OrderItemCollection', 'App\Model\OrderItemCollection');
    }

    private function _assembleAddress()
    {
        $this->_im->setParameters('App\Model\Address', [
            'table' => 'App\Model\Resource\Table\Address',
            'addressResource' => 'App\Model\Resource\DBEntity',
            'region' => 'App\Model\Region',
            'city' => 'App\Model\City'
        ]);

        $this->_im->addAlias('Address', 'App\Model\Address');
    }

    private function _assembleQuote()
    {
        $this->_im->setParameters('App\Model\Quote', [
            'table' => 'App\Model\Resource\Table\Quote',
            'items' => $this->_di->get('App\Model\QuoteItemCollection'),
            'address' => $this->_di->get('App\Model\Address'),
            'collectorsFactory' => $this->_di->get('App\Model\Quote\CollectorsFactory')
        ]);
        $this->_im->addAlias('Quote', 'App\Model\Quote');
    }

    private function _assembleCollectors()
    {
        $this->_im->setParameters('App\Model\Quote\CollectorsFactory', [
            'product' => $this->_di->get('App\Model\Product')
        ]);
    }

    private function _assembleOrder()
    {
        $this->_im->setParameters('App\Model\Order', [
            'orderItemCollection' => $this->_di->get('App\Model\OrderItemCollection'),
            'table' => 'App\Model\Resource\Table\Order'
        ]);
        $this->_im->addAlias('Order', 'App\Model\Order');
    }

    private function _assembleCustomer()
    {
        $this->_im->setParameters('App\Model\Customer', ['table' => 'App\Model\Resource\Table\Customer']);
        $this->_im->addAlias('Customer', 'App\Model\Customer');
    }

    private function _assembleAdmin()
    {
        $this->_im->setParameters('App\Model\Admin', ['table' => 'App\Model\Resource\Table\Admin']);
        $this->_im->addAlias('Admin', 'App\Model\Admin');
    }

    private function _assembleCity()
    {
        $this->_im->setParameters('App\Model\City', ['table' => 'App\Model\Resource\Table\City']);
        $this->_im->addAlias('City', 'App\Model\City');

        $this->_im->setParameters('App\Model\CityCollection', ['table' => 'App\Model\Resource\Table\City']);
        $this->_im->addAlias('CityCollection', 'App\Model\CityCollection');
    }

    private function _assembleRegion()
    {
        $this->_im->setParameters('App\Model\Region', ['table' => 'App\Model\Resource\Table\Region']);
        $this->_im->addAlias('Region', 'App\Model\Region');

        $this->_im->setParameters('App\Model\RegionCollection', ['table' => 'App\Model\Resource\Table\Region']);
        $this->_im->addAlias('RegionCollection', 'App\Model\RegionCollection');
    }


    private function _assembleView()
    {
        $this->_im->setParameters('App\Model\ModelView', [
            'layoutDir' => __DIR__ . '/../views/',
            'templateDir' => __DIR__ . '/../views/',
            'layout' => 'layout'
        ]);
        $this->_im->addAlias('View', 'App\Model\ModelView');
    }

    private function _assembleSession()
    {
        $this->_im->addAlias('Session', 'App\Model\Session');
        $this->_im->setParameters('App\Model\ISessionUser', [
            'session' => $this->_di->get('Session')
        ]);
    }

    private function _assembleFactories()
    {
        $this->_im->addAlias('ShippingFactory', 'App\Model\Shipping\Factory');

        $this->_im->addAlias('PaymentFactory', 'App\Model\Payment\Factory');

        $this->_im->addAlias('ConverterFactory', 'App\Model\Quote\ConverterFactory');
    }

    private function _assembleConverters()
    {
        $this->_im->addAlias('QuoteConverter', 'App\Model\Quote\Converter');
    }

    private function _assembleSmtpAndMail()
    {
        $this->_im->addAlias('SmtpOptions', 'Zend\Mail\Transport\SmtpOptions');
        $this->_im->addAlias('Smtp', 'Zend\Mail\Transport\Smtp');
        $this->_im->addAlias('ZendMessage', '\Zend\Mail\Message');
    }
}
