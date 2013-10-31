<?php
require_once __DIR__ . '/../src/ProductCollection.php';
require_once __DIR__ . '/../src/Product.php';

$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar'])]);
if (assert($products->getProducts() == [new Product(['sku' => 'fuu']), new Product(['sku' => 'bar'])], 'error')) {
    echo '1 ';
}

$products = new ProductCollection([new Product([]), new Product([])]);
if (assert($products->getSize() == 2, 'error')) {
    echo '2 ';
}

$products = new ProductCollection([new Product([])]);
if (assert($products->getSize() == 1)) {
    echo '3 ';
}

$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->limit(15);
if (assert($products->getSize() == 3)) {
    echo '4 ';
}

if (assert($products->getProducts() == [new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])])) {
    echo '5 ';
}

$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->offset(0);
if (assert($products->getProducts() == [new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])], 'error')) {
    echo '6 ';
}
$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->offset(1);
if (assert($products->getProducts() == [new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])])) {
    echo '7 ';
}
$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->offset(2);
if (assert($products->getProducts() == [new Product(['sku' => 'baz'])])) {
    echo '8 ';
}

echo "\n";

$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);

$products->limit(2);
$products->offset(2);
if (assert($products->getProducts() == [new Product(['sku' => 'baz'])])) {
    echo '9 ';
}
if (assert($products->getSize() == 1)) {
    echo '10 ';
}

$products->limit(-2);
$products->offset(2);
if (assert($products->getProducts() == [])) {
    echo '9 ';
}
if (assert($products->getSize() == 0)) {
    echo '10 ';
}

$products->limit(2);
$products->offset(-2);
if (assert($products->getProducts() ==  [new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])])) {
    echo '11 ';
}
if (assert($products->getSize() == 2)) {
    echo '12 ';
}

$products->limit(-1);
$products->offset(-1);
if (assert($products->getProducts() == [])) {
    echo '13 ';
}
if (assert($products->getSize() == 1)) {
    echo '14 ';
}

echo "\n";
