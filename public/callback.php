<?php
require_once '../api/config.php';
require_once '../api/auth.php';
require_once '../api/product.php';
require_once '../api/order.php';
require_once '../api/utils.php';
require_once '../api/webhook.php';
use EcomPHP\TiktokShop\Resources\Product;
use EcomPHP\TiktokShop\Resources\Fulfillment;


echo "ciao sei entrato nel callback\n";
/*


// 获取订单详情
//if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getOrder') {
  //  $orderId = $_GET['order_id'];
    $orderId = '576668886353153156';

    $orderData = getOrderRequest($orderId);

    if ($orderData !== null) {
        logError('success to get order details\n');
        echo "success to get order details\n";
    } else {
        logError('Failed to get order details\n');
        echo "Failed to get order details\n";
       
    }
//}



// 创建产品
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
    echo "createProduct has been saved to ../logs/createProduct.log\n";
    file_put_contents('../logs/createProduct.log', print_r($result, true) . "\n", FILE_APPEND);

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    file_put_contents('../logs/Error.log', "Error fetching order: " . $e->getMessage() . "\n", FILE_APPEND);
}


*/



// 调用 Update Inventory  方法

$params = [
  "skus" => [
    [
      "id" => "1729592969712207013",
      "inventory" => [
        [
          "quantity" => 999,
          "warehouse_id" => "7068517275539719942"
        ]
      ]
    ]
  ]
];

$product_id='1729382561353664372';

try {
  $product = $client->Product;
  $result = $product->updateInventory($product_id, $params = []);
  print_r($result);
  echo "updateInventory has been saved to ../logs/updateInventory.log\n";
  file_put_contents('../logs/updateInventory.log', print_r($result, true) . "\n", FILE_APPEND);

} catch (Exception $e) {
  echo 'Error: ' . $e->getMessage();
  file_put_contents('../logs/Error.log', "Error updateInventory: " . $e->getMessage() . "\n", FILE_APPEND);
}





// 调用 updatePackageShippingInfo 方法
$package_id = '1153048183880060036';
$tracking_number = '1515';
$shipping_provider_id = '7207996952661722922';
try {
$result = $client->Fulfillment->updatePackageShippingInfo($package_id, $tracking_number, $shipping_provider_id);

file_put_contents('../logs/updatePackageShippingInfo.log', print_r($result, true) . "\n", FILE_APPEND);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    file_put_contents('../logs/Error.log', "Error fetching updatePackageShippingInfo: " . $e->getMessage() . "\n", FILE_APPEND);
}



// updatePackageDeliveryStatus
$package = [[
    "delivery_type" => "DELIVERY_SUCCESS",
    "fail_delivery_reason" => "INVALID_ADDRESS",
    "id" => "1153048183880060036"]
];

try {
    $result = $client->Fulfillment->updatePackageDeliveryStatus($package);
    print_r($result);
    echo "updatePackageDeliveryStatus has been saved to ../logs/updatePackageDeliveryStatus.log\n";
    file_put_contents('../logs/PackageDeliveryStatus.log', print_r($result, true) . "\n", FILE_APPEND);
//$package = json_encode($data);

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    file_put_contents('../logs/Error.log', "Error fetching updatePackageDeliveryStatus: " . $e->getMessage() . "\n", FILE_APPEND);
}





// Ship Package

$package_id = '1153048183880060036';
    $handover_method = 'PICKUP';
    $pickup_slot= [[
        "end_time"=> "1623812664",
        "start_time"=> "1623812664"]
    ];
    $self_shipmen= [[
        
      "shipping_provider_id"=> "7207996952661722922",
        "tracking_number"=> "1515"]
    ];


try {
    $result = $client->Fulfillment->shipPackage($package_id, $handover_method = 'PICKUP', $pickup_slot = [], $self_shipment = []);
    print_r($result);
    echo "shipPackage has been saved to ../logs/shipPackage.log\n";
    file_put_contents('../logs/shipPackage.log', print_r($result, true) . "\n", FILE_APPEND);
//$package = json_encode($data);

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    file_put_contents('../logs/Error.log', "Error fetching shipPackage: " . $e->getMessage() . "\n", FILE_APPEND);
}







/*

//webhook
$webhook = getwebhookdata();
if ($webhook) {
    logError('success to get webhook\n');
    echo "success to get webhooks\n";
} else {
    logError('Failed to get webhook\n');
    echo "Failed to get webhook\n";
}


*/

?>