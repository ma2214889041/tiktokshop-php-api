<?php
require_once 'config.php';
require_once 'utils.php';

use EcomPHP\TiktokShop\webhook;
use EcomPHP\TiktokShop\Errors\TiktokShopException;

function getwebhookdata() {
    

    global $client;
   // $webhook = $client->webhook();

    $webhook = new Webhook($client);
try {
    $webhook->verify();
    logMessage("POST data: " . json_encode($_POST));
    $webhook->capture($_POST);
    
    $rawData = file_get_contents('php://input');
    logMessage("Received webhook request data: " . $rawData);
    $webhook->capture(json_decode($rawData, true));

} catch (TiktokShopException $e) {
    echo "webhook error: " . $e->getMessage() . "\n";
}


echo "Type: " . $webhook->getType() . "\n";
echo "Timestamp: " . $webhook->getTimestamp() . "\n";
echo "Shop ID: " . $webhook->getShopId() . "\n";
echo "Data: \n"; // data is array
print_r($webhook->getData());
    logMessage("webhook retrieved " );
    
        file_put_contents('../logs/webhook.txt', print_r($webhook, true) . "\n", FILE_APPEND);
        return $webhook;

}
