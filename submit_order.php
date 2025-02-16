<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the raw POST data
$raw_data = file_get_contents("php://input");
file_put_contents("order_log.txt", "Raw Data: " . $raw_data . "\n", FILE_APPEND);
$data = json_decode($raw_data, true);
file_put_contents("order_log.txt", "Parsed Data: " . print_r($data, true) . "\n", FILE_APPEND);

if (!isset($data["phone"]) || !isset($data["address"]) || !isset($data["cart"])) {
    echo json_encode(["message" => "Invalid order data received."]);
    exit;
}

$phone = preg_replace("/[^0-9]/", "", $data["phone"]);
$address = htmlspecialchars($data["address"]);
$cart = $data["cart"];

if (empty($phone) || !preg_match("/^[0-9]+$/", $phone)) {
    echo json_encode(["message" => "Invalid phone number. Only digits allowed."]);
    exit;
}

// Construct a response
$totalPrice = 0;
foreach ($cart as $item) {
    $totalPrice += $item["price"];
}

$response = [
    "message" => "Order validated successfully.",
    "total" => number_format($totalPrice, 2),
    "phone" => $phone,
    "address" => $address
];

echo json_encode($response);
?>
