<?php
require_once __DIR__ . '/../src/Product.php';


$product = new Product(['sku' => '12345']);
if (assert($product->getSku() == '12345', 'Returns SKU which has been initialized')) {
    echo '.';
}

$product = new Product(['sku' => '567890']);
if (assert($product->getSku() == '567890', 'Returns SKU which has been initialized')) {
    echo '.';
}


$product = new Product(['name' => 'Nokio']);
if (assert($product->getName() == 'Nokio', 'Returns name which has been initialized')) {
    echo '.';
}
$product = new Product(['name' => 'Motorobla']);
if (assert($product->getName() == 'Motorobla', 'Returns name which has been initialized')) {
    echo '.';
}


$product = new Product(['image' => 'http://url.ru/img.jpg']);
if (assert($product->getImage() == 'http://url.ru/img.jpg', 'Returns image which has been initialized')) {
    echo '.';
}
$product = new Product(['image' => 'http://url.ru/img2.jpg']);
if (assert($product->getImage() == 'http://url.ru/img2.jpg', 'Returns image which has been initialized')) {
    echo '.';
}



$product = new Product(['price' => 123.5]);
if (assert($product->getPrice() == 123.5, 'Returns price which has been initialized')) {
    echo '.';
}
$product = new Product(['price' => 42]);
if (assert($product->getPrice() == 42, 'Returns price which has been initialized')) {
    echo '.';
}


$product = new Product(['special_price' => 123.5]);
if (assert($product->getSpecialPrice() == 123.5, 'Returns special price which has been initialized')) {
    echo '.';
}
$product = new Product(['special_price' => 42]);
if (assert($product->getSpecialPrice() == 42, 'Returns special price which has been initialized')) {
    echo '.';
}


$productWithSpecial = new Product(['special_price' => 123.5]);
if (assert($productWithSpecial->isSpecialPriceApplied() === true, 'Returns true if special price applied')) {
    echo '.';
}

$productWithSpecial = new Product([]);
if (assert($productWithSpecial->isSpecialPriceApplied() === false, 'Returns true if special price applied')) {
    echo '.';
}
echo "\n";
