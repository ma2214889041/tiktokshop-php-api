<?php
session_start();
require_once 'vendor/autoload.php';
use EcomPHP\TiktokShop\Client;

$app_key = '6ccn15jc7u8ri';
$app_secret = '11cbb05c7e0eb5af3c8c200509c8f53c9889e3ab';
$client = new Client($app_key, $app_secret);

// 获取Auth对象
$auth = $client->auth();

// 处理授权
if (isset($_GET['code'])) {
    $authorization_code = $_GET['code'];
    $token = $auth->getToken($authorization_code);
    var_dump($token); // 调试语句,输出$token的值和结构
    $access_token = $token['access_token'];
    $refresh_token = $token['refresh_token'];

// extract shop_id & cipher from $authorizedShopList for use later
} else {
    $_SESSION['state'] = $state = bin2hex(random_bytes(20)); // 生成随机字符串
    $authUrl = $auth->createAuthRequest($state, true);

    ob_start(); // 开始输出缓冲
    var_dump($authUrl); // 输出调试信息
    $debugOutput = ob_get_clean(); // 获取缓冲区内容并清空缓冲区
    file_put_contents('debug.log', $debugOutput, FILE_APPEND); // 将调试信息写入日志文件
    header('Location: ' . $authUrl); // 发送重定向头信息
    exit;
    
    
}

// 设置访问令牌
$client->setAccessToken($access_token);

// 获取授权的商店信息
$authorizedShopList = $client->Authorization->getAuthorizedShop();
var_dump($authorizedShopList); // 调试语句,输出$authorizedShopList的值和结构
$shop_id = $authorizedShopList[0]['shop_id'];
$shop_cipher = $authorizedShopList[0]['cipher'];
