<?php
require_once __DIR__ . '/../src/ProductCollection.php';
require_once __DIR__ . '/../src/Product.php';

$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar'])]);
if (assert($products->getProducts() == [new Product(['sku' => 'fuu']), new Product(['sku' => 'bar'])], 'error')) {
    echo '1';
}

$products = new ProductCollection([new Product([]), new Product([])]);
if (assert($products->getSize() == 2, 'error')) {
    echo '2';
}

$products = new ProductCollection([new Product([])]);
if (assert($products->getSize() == 1, 'error')) {
    echo '3';
}

$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->limit(1);
if (assert($products->getSize() == 1)) {
    echo '4';
}
if (assert($products->getProducts() == [new Product(['sku' => 'fuu'])], '…')) {
    echo '5';
}

$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->offset(0);
if (assert($products->getProducts() == [new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])], 'error')) {
    echo '6';
}
$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->offset(1);
if (assert($products->getProducts() == [new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])], 'error')) {
    echo '7';
}
$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->offset(2);
if (assert($products->getProducts() == [new Product(['sku' => 'baz'])], 'error')) {
    echo '8';
}
