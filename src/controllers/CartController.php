<?php
namespace App\Controller;

use App\Model\CartHelper;

class CartController
{
    public function listAction()
    {
        $cartHelper = new CartHelper;
        $counts = [];
        $products = $cartHelper->fetchCartProducts($counts);
        $viewName = 'cart_list';
        $headerText = 'Shopping Cart';

        require_once __DIR__ . '/../views/layout.phtml';
    }

    public function changeCountAction()
    {
        if (isset($_POST['action']) && isset($_POST['count']) && isset($_POST['product_id'])) {
            $cartHelper = new CartHelper;
            $cartHelper->changeProductCount($_POST['action'], $_POST['count'], $_POST['product_id']);
        }
        $this->listAction();
    }
}