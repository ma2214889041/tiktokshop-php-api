<?php
require_once 'config.php';
require_once 'utils.php';

session_start();


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


// 设置访问令牌和店铺密钥
$client->setAccessToken($_SESSION['access_token']);
$client->setShopCipher($shop_cipher);