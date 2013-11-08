<?php

require_once __DIR__ . '/../models/ProductCollection.php';
require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    public function listAction()
    {
        $products = new ProductCollection([
            new Product([
                'image' => 'http://thememaker.ru/storage/Image/img_mobile/Nokia_5130.jpg',
                'name' => 'Nokia',
                'sku' => '1231241241234234',
                'price' => 1000,
                'special_price' => 99.99
            ]),
            new Product([
                'image' => 'http://thememaker.ru/storage/Image/img_mobile/Nokia_5130.jpg',
                'name' => 'Nokia',
                'sku' => '1231241241234234',
                'price' => 1000,
                'special_price' => 99.99
            ]),
            new Product([
                'image' => 'http://thememaker.ru/storage/Image/img_mobile/Nokia_5130.jpg',
                'name' => 'Nokia',
                'sku' => '1231241241234234',
                'price' => 1000,
                'special_price' => 99.99
            ]),
            new Product([
                'image' => 'http://cs413626.vk.me/v413626920/1de3/qh7lApBwRCo.jpg',
                'name' => 'Samsung',
                'sku' => '12312412123123',
                'price' => 1000
            ]),
            new Product([
                'image' => 'http://thememaker.ru/storage/Image/img_mobile/Nokia_5130.jpg',
                'name' => 'Nokia',
                'sku' => '1231241241234234',
                'price' => 1000,
                'special_price' => 99.99
            ])
        ]);

        require_once __DIR__ . '/../views/product_list.phtml';
    }
    public function viewAction()
    {
        require_once __DIR__ . '/../views/product_view.phtml';
    }
}