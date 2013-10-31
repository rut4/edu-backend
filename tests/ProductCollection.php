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
    echo '10 ';
}
if (assert($products->getSize() == 0)) {
    echo '11 ';
}

$products->limit(2);
$products->offset(-2);
if (assert($products->getProducts() ==  [new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])])) {
    echo '12 ';
}
if (assert($products->getSize() == 2)) {
    echo '13 ';
}

$products->limit(-1);
$products->offset(-1);
if (assert($products->getProducts() == [])) {
    echo '14 ';
}
if (assert($products->getSize() == 0)) {
    echo '15 ';
}

echo "\n";
