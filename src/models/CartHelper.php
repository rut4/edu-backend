<?php
namespace App\Model;

use App\Model\ProductCollection;
use App\Model\Resource\Table\CartEntity as CartEntityTable;
use App\Model\ReviewCollection;
use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;
use App\Model\Product;
use App\Model\Resource\PDOHelper;
use App\Model\Resource\Table\Product as ProductTable;
use App\Model\Resource\Table\Review as ReviewTable;
use App\Model\Session;


class CartHelper
{
    public function addProduct($productId)
    {
        if (!isset($productId)) {
            return;
        }
        $session = new Session;
        $cartEntity = new DBEntity(PDOHelper::getPdo(), new CartEntityTable);
        $cart = new DBCollection(PDOHelper::getPdo(), new CartEntityTable);

        if ($session->isLoggedIn()) {
            $identField = 'customer_id';
            $identValue = $session->getCustomer()->getId();
        } else {
            $identField = 'session_id';
            $identValue = session_id();
        }

        $cart->filterBy('product_id', $productId);
        $cart->filterBy($identField, $identValue);
        $fetchedCartEntity = $cart->fetch();

        if (count($fetchedCartEntity) == 1) {
            $preparedOrder = reset($fetchedCartEntity);
            $preparedOrder['count']++;
        } else {
            $preparedOrder = [];
            $preparedOrder['product_id'] = $productId;
            $preparedOrder[$identField] = $identValue;
            $preparedOrder['count'] = 1;
        }
        $cartEntity->save($preparedOrder);
    }

    public function changeProductCount($action, $postCount, $productId)
    {
        $session = new Session;
        $cartEntity = new DBEntity(PDOHelper::getPdo(), new CartEntityTable);
        $cartEntities = new DBCollection(PDOHelper::getPdo(), new CartEntityTable);

        $this->_chooseCustomerIdentifier($session, $cartEntities);
        $cartEntities->filterBy('product_id', $productId);
        $fetchedCartEntity = reset($cartEntities->fetch());
        if ($postCount && $postCount > 0) {
            $count = $postCount;
        } else {
            $count = 0;
        }
        if ($action == 'Add') {
            $fetchedCartEntity['count'] += $count;
            $cartEntity->save($fetchedCartEntity);
        } else if ($action == 'Remove') {
            $fetchedCartEntity['count'] -= $count < $fetchedCartEntity['count'] ?
                $count : $fetchedCartEntity['count'];

            if ($fetchedCartEntity['count'] == 0) {
                $cartEntity->remove($fetchedCartEntity['prepared_order_id']);
            } else {
                $cartEntity->save($fetchedCartEntity);
            }
        }
    }

    public function fetchCartProducts(array &$counts)
    {
        $session = new Session();
        $product = new DBEntity(PDOHelper::getPdo(), new ProductTable);
        $cartEntities = new DBCollection(PDOHelper::getPdo(), new CartEntityTable);
        $this->_chooseCustomerIdentifier($session, $cartEntities);
        $products = array_map(function ($entity) use ($product, &$counts) {
            $counts[] = $entity['count'];

            return new Product($product->find($entity['product_id']));
        }, $cartEntities->fetch());

        return $products;
    }

    private function _chooseCustomerIdentifier(Session $session, DBCollection $cartEntities)
    {
        if ($session->isLoggedIn()) {
            $column = 'customer_id';
            $value = $session->getCustomer()->getId();
        } else {
            $column = 'session_id';
            $value = session_id();
        }
        $cartEntities->filterBy($column, $value);
    }
}