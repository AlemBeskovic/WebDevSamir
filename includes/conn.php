<?php
// conn.php

$servername = "127.0.0.1"; 
$username = "root";        
$password = "";           
$dbname = "SamirFinalProject"; // database name

try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);


    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("CREATE TABLE IF NOT EXISTS `users` (
        `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `username` VARCHAR(50) NOT NULL,
        `email` VARCHAR(100) NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `full_name` VARCHAR(100) DEFAULT NULL,
        `userType` ENUM('customer', 'merchant') NOT NULL DEFAULT 'customer',
        `FileData` LONGBLOB DEFAULT NULL,
        `address` VARCHAR(255) NOT NULL,
        `city` VARCHAR(100) NOT NULL,
        `state` VARCHAR(100) NOT NULL,
        `zip_code` VARCHAR(20) NOT NULL,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    )");

$conn->exec("CREATE TABLE IF NOT EXISTS `products` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `merchant_id` INT(11) UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `price` DECIMAL(10, 2) NOT NULL,
    `stock` INT(11) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`merchant_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
)");

$conn->exec("CREATE TABLE IF NOT EXISTS `reports` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `customer_id` INT(11) UNSIGNED NOT NULL,
    `product_id` INT(11) UNSIGNED NOT NULL,
    `quantity_sold` INT(11) NOT NULL,
    `total_price` DECIMAL(10, 2) NOT NULL,
    `customer_name` VARCHAR(100) NOT NULL,
    `customer_address` VARCHAR(255) NOT NULL,
    `customer_city` VARCHAR(100) NOT NULL,
    `customer_state` VARCHAR(100) NOT NULL,
    `customer_zip_code` VARCHAR(20) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)
)");

    $conn->exec("CREATE TABLE IF NOT EXISTS `images` (
        `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `title` VARCHAR(255) NOT NULL,
        `image_path` VARCHAR(255) NOT NULL,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    )");


} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit();
}
?>
