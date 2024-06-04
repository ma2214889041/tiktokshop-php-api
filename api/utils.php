<?php

function logMessage($message) {
    global $logFile;
    file_put_contents($logFile, date('Y-m-d H:i:s') . ' ' . $message . "\n", FILE_APPEND);
}

function logError($message) {
    logMessage('ERROR: ' . $message);
}

function handleAuthCallback() {
    global $client, $shop_cipher;

    if (isset($_GET['code'])) {
        $authorizationCode = $_GET['code'];
        $state = $_GET['state'];

        // 验证状态参数
        if (!isset($_SESSION['state']) || $state !== $_SESSION['state']) {
            logError('State mismatch. Possible CSRF attack.');
            die('State mismatch');
        }

        try {
            $token = $client->auth()->getToken($authorizationCode);
            $_SESSION['access_token'] = $token['access_token'];
            logMessage("Access token obtained: " . $token['access_token']);

            // 设置访问令牌和店铺密钥
            $client->setAccessToken($_SESSION['access_token']);
            $client->setShopCipher($shop_cipher);
        } catch (Exception $e) {
            logError('Error getting access token: ' . $e->getMessage());
            die('Error getting access token');
        }
    } else {
        // 如果没有授权码,重定向到授权页面
        $state = bin2hex(random_bytes(16));
        $_SESSION['state'] = $state;

        $authUrl = $client->auth()->createAuthRequest($state, true);
        header('Location: ' . $authUrl);
        exit;
    }
}