<?php
require_once 'config.php';
require_once 'utils.php';

use EcomPHP\TiktokShop\Resources\Product;

function createProduct($productData) {
    global $client;

    try {
        $product = $client->Product;
        $result = $product->createProduct($productData);
        file_put_contents('../logs/createProduct.log', print_r($result, true) . "\n", FILE_APPEND);
        return $result;
    } catch (Exception $e) {
        logError('Error creating product: ' . $e->getMessage());
        file_put_contents('../logs/Error.log', "Error fetching order: " . $e->getMessage() . "\n", FILE_APPEND);

        return null;
    }
}

function getProductList($params) {
    global $client;

    try {
        $product = $client->Product;
        $result = $product->searchProducts($params);
        return $result;
    } catch (Exception $e) {
        logError('Error getting product list: ' . $e->getMessage());
        return null;
    }
}

// 在这里添加其他与产品相关的函数...