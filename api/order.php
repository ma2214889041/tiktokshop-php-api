<?php
require_once 'config.php';
require_once 'utils.php';

use EcomPHP\TiktokShop\Resources\Order;

function getOrderRequest($orderId) {
    global $client;

    try {
        $order = $client->Order;
        $orderData = $order->getOrderDetail([$orderId]);
        logMessage("Order data retrieved for order ID: " . $orderId);
        file_put_contents('../logs/order', print_r($orderData, true) . "\n", FILE_APPEND);
        return $orderData;
    } catch (Exception $e) {
        logError('Error getting order details: ' . $e->getMessage());
        file_put_contents('../logs/Error.log', "Error fetching order: " . $e->getMessage() . "\n", FILE_APPEND);
        return null;
    }
}

function getOrderListRequest($params) {
    global $client;

    try {
        $order = $client->Order;
        $orderList = $order->getOrderList($params);
        logMessage("Order list retrieved with params: " . json_encode($params));
        return $orderList;
    } catch (Exception $e) {
        logError('Error getting order list: ' . $e->getMessage());
        return null;
    }
}

function updateOrderRequest($orderId, $params) {
    global $client;

    try {
        $order = $client->Order;
        $result = $order->updateOrder($orderId, $params);
        logMessage("Order updated for order ID: " . $orderId);
        return $result;
    } catch (Exception $e) {
        logError('Error updating order: ' . $e->getMessage());
        return null;
    }
}

function cancelOrderRequest($orderId, $params) {
    global $client;

    try {
        $order = $client->Order;
        $result = $order->cancelOrder($orderId, $params);
        logMessage("Order cancelled for order ID: " . $orderId);
        return $result;
    } catch (Exception $e) {
        logError('Error cancelling order: ' . $e->getMessage());
        return null;
    }
}

// 在这里添加其他与订单相关的函数...