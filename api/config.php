<?php
// TikTok Shop API 配置
require_once '../vendor/autoload.php';

$app_key = '6ccn15jc7u8ri';
$app_secret = '11cbb05c7e0eb5af3c8c200509c8f53c9889e3ab';
$shop_cipher = 'GCP_yM6x8gAAAADoGEyPMRWyyGL3OfBEtg38';
$shop_id = '7495755148871305749';

use EcomPHP\TiktokShop\Resources\Product;
use EcomPHP\TiktokShop\Client;


// 创建 TikTok Shop 客户端实例
$client = new EcomPHP\TiktokShop\Client($app_key, $app_secret);

// 日志文件路径
$logFile = '../logs/tiktok-shop.log';