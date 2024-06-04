<?php
session_start();
require_once '../vendor/autoload.php';
use EcomPHP\TiktokShop\Client;

$app_key = '6ccn15jc7u8ri';
$app_secret = '11cbb05c7e0eb5af3c8c200509c8f53c9889e3abt';
$client = new Client($app_key, $app_secret);

// 获取Auth对象
$auth = $client->auth();

// 创建授权请求并获取URL
$_SESSION['state'] = $state = bin2hex(random_bytes(20));
$authUrl = $auth->createAuthRequest($state, true);

// 将调试信息写入日志文件
file_put_contents('../logs/debug.log', "Auth URL: $authUrl\n", FILE_APPEND);

// 重定向用户到授权URL
header('Location: ' . $authUrl);
exit();
?>
