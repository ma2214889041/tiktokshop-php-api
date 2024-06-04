<?php
session_start();
require_once '../vendor/autoload.php';
use EcomPHP\TiktokShop\Client;
use EcomPHP\TiktokShop\Resources\Order;
use EcomPHP\TiktokShop\Resources\Product;


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

/*

$order_id = '576668886353153156';
$orderData = getOrder($client, $shop_id, $shop_cipher, $order_id);
if ($orderData) {
    // 订单数据已经保存到 ../logs/.order.txt 文件
    echo "Order data has been saved to ../logs/.order.txt";
} else {
    // 错误信息已经保存到 ../logs/Error.log 文件
    echo "Error occurred. Please check ../logs/Error.log for details.";
}
*/


$productData = [
  "brand_id" => "7082427311584347905",
  "category_id" => "600001",
  "certifications" => [
    [
      "files" => [
        [
          "format" => "PDF",
          "id" => "v09ea0g40000cj91373c77u3mid3g1s0",
          "name" => "brand_cert.PDF"
        ]
      ],
      "id" => "7182427311584347905",
      "images" => [
        [
          "uri" => "tos-maliva-i-o3syd03w52-us/c668cdf70b7f483c94dbe"
        ]
      ]
    ]
  ],
  "description" => " dfdsv",
  "external_product_id" => "172959296971220002",
  "is_cod_allowed" => false,
  "main_images" => [
    [
      "uri" => "tos-maliva-i-o3syd03w52-us/c668cdf70b7f483c94dbe"
    ]
  ],
  "manufacturer" => [
    "address" => "123W 106th St, New York, NY, USA, 10025",
    "email" => "samplemanufacturer101@outlook.com",
    "name" => "Sample Manufacturer Name\n",
    "phone_number" => "4412345678"
  ],
  "package_dimensions" => [
    "height" => "10",
    "length" => "10",
    "unit" => "CENTIMETER",
    "width" => "10"
  ],
  "package_weight" => [
    "unit" => "KILOGRAM",
    "value" => "1.32"
  ],
  "primary_combined_product_id" => "1729582718312380123",
  "product_attributes" => [
    [
      "id" => "100392",
      "values" => [
        [
          "id" => "1001533",
          "name" => "Birthday"
        ]
      ]
    ]
  ],
  "save_mode" => "LISTING",
  "size_chart" => [
    "image" => [
      "uri" => "tos-maliva-i-o3syd03w52-us/c668cdf70b7f483c94dbe"
    ],
    "template" => [
      "id" => "7267563252536723205"
    ]
  ],
  "skus" => [
    [
      "combined_skus" => [
        [
          "product_id" => "1729582718312380123",
          "sku_count" => 1,
          "sku_id" => "2729382476852921560"
        ]
      ],
      "external_sku_id" => "1729592969712207012",
      "identifier_code" => [
        "code" => "10000000000000",
        "type" => "GTIN"
      ],
      "inventory" => [
        [
          "quantity" => 999,
          "warehouse_id" => "7068517275539719942"
        ]
      ],
      "price" => [
        "amount" => "1.21",
        "currency" => "USD\n"
      ],
      "sales_attributes" => [
        [
          "id" => "100089",
          "name" => "Color",
          "sku_img" => [
            "uri" => "tos-maliva-i-o3syd03w52-us/c668cdf70b7f483c94dbe"
          ],
          "value_id" => "1729592969712207000",
          "value_name" => "Red"
        ]
      ],
      "seller_sku" => "Color-Red-XM001",
      "sku_unit_count" => "100.00"
    ]
  ],
  "title" => "Men's Fashion Sports Low Cut Cotton Breathable Ankle Short Boat Invisible Socks",
  "video" => [
    "id" => "v09e40f40000cfu0ovhc77ub7fl97k4w"
  ]
];

try {
    $product = $client->Product;
    $result = $product->createProduct($productData);
    print_r($result);
    echo "createProduct has been saved to ../logs/createProduct.log";
    file_put_contents('../logs/createProduct.log', print_r($result, true) . "\n", FILE_APPEND);

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    file_put_contents('../logs/Error.log', "Error fetching order: " . $e->getMessage() . "\n", FILE_APPEND);
}




?>
