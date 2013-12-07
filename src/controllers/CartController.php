<?php
namespace App\Controller;

use \App\Model\Resource\DBEntity;
use \App\Model\Session;
use \App\Model\Product;
use \App\Model\Resource\PDOHelper;
use \App\Model\Resource\Table\Product as ProductTable;
use \App\Model\Resource\Table\CartEntity as CartEntityTable;
use \App\Model\Resource\DBCollection;

class CartController
{
    public function listAction()
    {
        $counts = [];
        $products = $this->_fetchCartProducts($counts);
        $viewName = 'cart_list';
        $headerText = 'Shopping Cart';

        require_once __DIR__ . '/../views/layout.phtml';
    }

    public function changeCountAction()
    {
        if (isset($_POST['action'])) {
            $session = new Session;
            $cartEntity = new DBEntity(PDOHelper::getPdo(), new CartEntityTable);
            $cartEntities = new DBCollection(PDOHelper::getPdo(), new CartEntityTable);

            $this->_chooseCustomerIdentifier($session, $cartEntities);
            $cartEntities->filterBy('product_id', $_POST['product_id']);
            $fetchedCartEntity = reset($cartEntities->fetch());
            if (isset($_POST['count']) && $_POST['count'] > 0) {
                $count = $_POST['count'];
            } else {
                $count = 0;
            }
            if ($_POST['action'] == 'Add') {
                $fetchedCartEntity['count'] += $count;
                $cartEntity->save($fetchedCartEntity);
            } else if ($_POST['action'] == 'Remove') {
                $fetchedCartEntity['count'] -= $count < $fetchedCartEntity['count'] ?
                    $count : $fetchedCartEntity['count'];

                if ($fetchedCartEntity['count'] == 0) {
                    $cartEntity->remove($fetchedCartEntity['prepared_order_id']);
                } else {
                    $cartEntity->save($fetchedCartEntity);
                }
            }

        }
        $this->listAction();
    }

    private function _fetchCartProducts(array &$counts)
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

    /**
     * @param $session
     * @param $cartEntities
     */
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