<?php
try {
    $mysqli = new mysqli("localhost", "root", "");
    $sql = "CREATE DATABASE IF NOT EXISTS `online_shop`";
    if ($mysqli->query($sql)) {
        if ($mysqli->select_db("online_shop")) {
            create_table($mysqli);
            echo "Created Successfully";
        }
    }
} catch (\Throwable $th) {
    echo "Can not connect to Database!";
    die();
}

// auto create all table when our index page is loaded
function create_table($mysqli)
{
    $sql = "CREATE TABLE IF NOT EXISTS `user`(`user_id` INT AUTO_INCREMENT,`user_name` VARCHAR(70) NOT NULL,`email` VARCHAR(70) UNIQUE,`password` VARCHAR(220) NOT NULL,`address` VARCHAR(220) NOT NULL,`phone` VARCHAR(50) NOT NULL,`profile` LONGTEXT NOT NULL,`role` INT NOT NULL ,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY(`user_id`))";
    if (!$mysqli->query($sql)) {
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `category`(`category_id` INT AUTO_INCREMENT,`category_name` VARCHAR(70) UNIQUE NOT NULL,`description` VARCHAR(225),created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY(`category_id`))";
    if (!$mysqli->query($sql)) {
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `product`(`product_id` INT AUTO_INCREMENT,`product_name` VARCHAR(70) UNIQUE NOT NULL,`photo` LONGTEXT NOT NULL,price INT NOT NULL,stock INT NOT NULL,`description` VARCHAR(225),category_id INT NOT NULL,PRIMARY KEY(`product_id`),created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(`category_id`) REFERENCES `category`(`category_id`))";
    if (!$mysqli->query($sql)) {
        return false;
    }
    $sql = "CREATE TABLE IF NOT EXISTS `stockAddition`(`stock_addition_id` INT AUTO_INCREMENT,`user_id` INT NOT NULL,`product_id` INT NOT NULL,qty_added INT NOT NULL,
    `notes` VARCHAR(225),`addition_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY(`stock_addition_id`),FOREIGN KEY(`user_id`) REFERENCES `user`(`user_id`),FOREIGN KEY(`product_id`) REFERENCES `product`(`product_id`))";
    if (!$mysqli->query($sql)) {
        return false;
    }
    $sql = "CREATE TABLE IF NOT EXISTS `productStockHistory`(`product_stock_history_id` INT AUTO_INCREMENT,`product_id` INT NOT NULL,`old_stock` INT NOT NULL,new_stock INT NOT NULL,`change_reason` VARCHAR(225),`user_id` INT NOT NULL,`change_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY(`product_stock_history_id`),FOREIGN KEY(`user_id`) REFERENCES `user`(`user_id`),FOREIGN KEY(`product_id`) REFERENCES `product`(`product_id`))";
    if (!$mysqli->query($sql)) {
        return false;
    }

    $sql = "CREATE TABLE IF NOT EXISTS `order`(`order_id` INT AUTO_INCREMENT,`user_id` INT NOT NULL,`status` int NOT NULL,total_amount INT NOT NULL,`shipping_address` VARCHAR(220) NOT NULL,`payment_method` VARCHAR(220) NOT NULL,order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY(`order_id`),FOREIGN KEY(`user_id`) REFERENCES `user`(`user_id`))";
    if (!$mysqli->query($sql)) {
        return false;
    }
    $sql = "CREATE TABLE IF NOT EXISTS `orderItem`(`order_item_id` INT AUTO_INCREMENT,`order_id` INT NOT NULL,`product_id` INT NOT NULL,`qty` INT NOT NULL,`unit_price` INT NOT NULL,PRIMARY KEY(`order_item_id`),FOREIGN KEY(`product_id`) REFERENCES `product`(`product_id`),FOREIGN KEY(`order_id`) REFERENCES `order`(`order_id`))";
    if (!$mysqli->query($sql)) {
        return false;
    }
    $sql = "CREATE TABLE IF NOT EXISTS `invoice`(`invoice_id` INT AUTO_INCREMENT,`order_id` INT NOT NULL,`invoice_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,`due_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,`total_amount` int NOT NULL,`status` int NOT NULL,PRIMARY KEY(`invoice_id`),FOREIGN KEY(`order_id`) REFERENCES `order`(`order_id`))";
    if (!$mysqli->query($sql)) {
        return false;
    }
    return true;
}
