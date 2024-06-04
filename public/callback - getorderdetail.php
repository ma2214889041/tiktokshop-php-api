<?php
session_start();
require_once '../vendor/autoload.php';
use EcomPHP\TiktokShop\Client;
use EcomPHP\TiktokShop\Resources\Order;

$app_key = '6ccn15jc7u8ri';
$app_secret = '11cbb05c7e0eb5af3c8c200509c8f53c9889e3ab';
$shop_cipher = 'GCP_yM6x8gAAAADoGEyPMRWyyGL3OfBEtg38';
$shop_id = '7495755148871305749';

$client = new Client($app_key, $app_secret);

// 检查状态参数
if (!isset($_GET['state']) || $_GET['state'] !== $_SESSION['state']) {
    die('State mismatch');
}

if (isset($_GET['code'])) {
    $authorization_code = $_GET['code'];
    $token = $client->auth()->getToken($authorization_code);
    $_SESSION['access_token'] = $token['access_token'];
    file_put_contents('../logs/access_token.log', "Access Token: " . $token['access_token'] . "\n", FILE_APPEND);
} else {
    die('Authorization code missing');
}

// 设置访问令牌
$client->setAccessToken($_SESSION['access_token']);
$client->setShopCipher($shop_cipher);
/*

// 获取授权的商店信息
$authorizedShopList = $client->Authorization->getAuthorizedShop();
file_put_contents('../logs/authorizedShopList.log', "Authorized Shop List: " . print_r($authorizedShopList, true) . "\n", FILE_APPEND);
$shop_id = $authorizedShopList['shops'][0]['id'];
$shop_cipher = $authorizedShopList['shops'][0]['cipher'];

*/

function getProductList($client) {
    $product = $client->Product;

    try {
        $productList = $product->searchProducts();
        file_put_contents('../logs/productList.log', "Product List: " . print_r($productList, true) . "\n", FILE_APPEND);
        return $productList;
    } catch (Exception $e) {
        file_put_contents('../logs/Error.log', "Error: " . $e->getMessage() . "\n", FILE_APPEND);
        return null;
    }
}

function createOrder($client, $shop_cipher, $app_secret) {
    $orderEndpoint = 'https://open-api.tiktokglobalshop.com/order/202309/orders';
    $orderParams = [
        'app_key' => $client->getAppKey(),
        'timestamp' => time(),
        'shop_cipher' => $shop_cipher,
        'ids' => '576668886353153156',
    ];

    $sign = calSign($orderEndpoint, 'POST', $orderParams, '', $app_secret);
    $orderParams['sign'] = $sign;

    try {
        $response = $client->post($orderEndpoint, [   // Uncaught Error: Call to undefined method 
            'query' => $orderParams,
        ]);
        $orderData = json_decode($response->getBody(), true);
        file_put_contents('../logs/Order.log', "Order Data: " . print_r($orderData, true) . "\n", FILE_APPEND);
        return $orderData;
    } catch (Exception $e) {
        file_put_contents('../logs/Error.log', "Error creating order: " . $e->getMessage() . "\n", FILE_APPEND);
        return null;
    }
}



function getOrder($client, $shop_id, $shop_cipher, $order_id) {
    try {
        $order = $client->Order;
        $orderData = $order->getOrderDetail([$order_id]);
        file_put_contents('../logs/.order.txt', print_r($orderData, true) . "\n", FILE_APPEND);
        return $orderData;
    } catch (Exception $e) {
        file_put_contents('../logs/Error.log', "Error fetching order: " . $e->getMessage() . "\n", FILE_APPEND);
        return null;
    }
}


//$productList = getProductList($client);
//$orderData = createOrder($client, $shop_cipher, $app_secret);


//$orders = $client->Order->getOrderList([
   // 'order_status' => Order::STATUS_UNPAID, // Unpaid order
   // 'page_size' => 50,
//]);


$order_id = '576668886353153156';
$orderData = getOrder($client, $shop_id, $shop_cipher, $order_id);
if ($orderData) {
    // 订单数据已经保存到 ../logs/.order.txt 文件
    echo "Order data has been saved to ../logs/.order.txt";
} else {
    // 错误信息已经保存到 ../logs/Error.log 文件
    echo "Error occurred. Please check ../logs/Error.log for details.";
}


?>
