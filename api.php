<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Sample product data with stock
$products = [
    ["id" => 1, "name" => "3D Printed Lamp", "price" => 49.99, "image" => "lamp.jpeg", "stock" => 10],
    ["id" => 2, "name" => "Custom Chair", "price" => 120.00, "image" => "chair.jpg", "stock" => 5],
    ["id" => 3, "name" => "Decorative Vase", "price" => 35.50, "image" => "vase.jpg", "stock" => 0],  // Out of stock
    ["id" => 4, "name" => "Modern Table", "price" => 199.99, "image" => "table.jpg", "stock" => 7],
    ["id" => 5, "name" => "Wooden Shelf", "price" => 89.99, "image" => "shelf.jpeg", "stock" => 2],
    ["id" => 6, "name" => "Office Desk", "price" => 250.00, "image" => "desk.jpg", "stock" => 0],  // Out of stock
    ["id" => 7, "name" => "Minimalist Sofa", "price" => 499.99, "image" => "sofa.jpg", "stock" => 8],
    ["id" => 8, "name" => "Elegant Mirror", "price" => 75.00, "image" => "mirror.jpg", "stock" => 1],
    ["id" => 9, "name" => "Classic Bookshelf", "price" => 150.00, "image" => "bookshelf.jpg", "stock" => 4]
];

// Convert to JSON and output
echo json_encode($products);
?>
