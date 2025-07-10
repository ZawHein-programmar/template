<?php

$host = 'localhost';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password);

if ($conn->connect_errno) {
    echo "Fail to connnect conn" . $conn->connect_error;
    exit;
}

function create_database($conn)
{
    $sql = "CREATE DATABASE IF NOT EXISTS 
            `gym_management_system_zh`
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE utf8mb4_general_ci";

    if ($conn->query($sql)) {
        return true;
    }
    return false;
}

create_database($conn);

function select_db($conn)
{
    if ($conn->select_db("gym_management_system_zh")) {
        return true;
    }
    return false;
}

select_db($conn);
create_table($conn);

function create_table($conn)
{
    //user table
    $user_sql = "CREATE TABLE IF NOT EXISTS `user` (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    profile VARCHAR(255) DEFAULT NULL,
    role ENUM('admin', 'user','staff') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";


    if ($conn->query($user_sql) === false) return false;

    //create member table
    $member_sql = "CREATE TABLE IF NOT EXISTS `member`
                    (member_id int AUTO_INCREMENT PRIMARY KEY,
                    member_name VARCHAR(50) NOT NULL,
                    email VARCHAR(100) NOT NULL UNIQUE,
                    phone VARCHAR(50) NOT NULL,
                    DOB DATE NOT NULL,
                    gender VARCHAR(10),
                    address VARCHAR(200) NOT NULL,
                    join_date DATE NOT NULL,
                    original_weight INT NOT NUll,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    )";

    if ($conn->query($member_sql) === false) return false;

    //create trainer table
    $trainer_sql = "CREATE TABLE IF NOT EXISTS `trainer`
                    (trainer_id int AUTO_INCREMENT PRIMARY KEY,
                    trainer_name VARCHAR(50) NOT NULL,
                    email VARCHAR(100) NOT NULL UNIQUE,
                    phone VARCHAR(50) NOT NULL,
                    specialty VARCHAR(255) NOT NULL,
                    gender VARCHAR(10),
                    bio VARCHAR(200) NOT NULL,
                    join_date DATE NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    )";

    if ($conn->query($trainer_sql) === false) return false;

    //create class table
    $class_sql = "CREATE TABLE IF NOT EXISTS `class`
                (class_id INT AUTO_INCREMENT PRIMARY KEY,
                class_name VARCHAR(100) NOT NULL,
                description VARCHAR(255) NOT NULL ,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";

    if ($conn->query($class_sql) === false) return false;

    //create class_schedules table
    $schedule_sql = "CREATE TABLE IF NOT EXISTS `class_schedule`
                (schedule_id INT AUTO_INCREMENT PRIMARY KEY,
                class_id int NOT NULL,
                day_of_week VARCHAR(50) NOT NULL ,
                start_time DATETIME NOT NULL,
                end_time DATETIME NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";

    if ($conn->query($schedule_sql) === false) return false;

    //create class_trainer tabel
    $class_trainer_sql = "CREATE TABLE IF NOT EXISTS `class_trainer`
                (class_trainer_id INT AUTO_INCREMENT PRIMARY KEY,
                trainer_id int NOT NULL,
                class_id int NOT NULL,
                price int NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";

    if ($conn->query($class_trainer_sql) === false) return false;

    //create member_class table
    $member_class_sql = "CREATE TABLE IF NOT EXISTS `member_class`
                (member_class_id INT AUTO_INCREMENT PRIMARY KEY,
                member_id int NOT NULL,
                class_trainer_id int NOT NULL,
                enrolled_date DATE NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";

    if ($conn->query($member_class_sql) === false) return false;

    //attendance table
    $attendance_sql = "CREATE TABLE IF NOT EXISTS `attendance`
                (attendance_id INT AUTO_INCREMENT PRIMARY KEY,
                check_in_time DATETIME NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";

    if ($conn->query($attendance_sql) === false) return false;

    //create discount table
    $discont_sql = "CREATE TABLE IF NOT EXISTS `discount`
                (discount_id INT AUTO_INCREMENT PRIMARY KEY,
                name_of_package VARCHAR(100) NOT NULL,
                percentage VARCHAR(100) NOT NULL ,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";

    if ($conn->query($discont_sql) === false) return false;

    //discount details table
    $discont_detail_sql = "CREATE TABLE IF NOT EXISTS `discount_detail`
                (discount_detail_id INT AUTO_INCREMENT PRIMARY KEY,
                discount_id int NOT NULL,
                start_date DATE NOT NULL,
                end_date DATE NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";

    if ($conn->query($discont_detail_sql) === false) return false;

    //payment table
    $payment_sql = "CREATE TABLE IF NOT EXISTS `payment`
                (payment_id INT AUTO_INCREMENT PRIMARY KEY,
                member_class_id int NOT NULL,
                member_id int NOT NULL,
                amount int NOT NULL,
                payment_date DATE NOT NULL,
                method VARCHAR(30) NOT NULL,
                detail_id int NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";

    if ($conn->query($payment_sql) === false) return false;


    // image table create
    $image_sql = "CREATE TABLE IF NOT EXISTS `image`
                (
                type ENUM('trainer','class') NOT NULL,
                target_id VARCHAR(100) NOT NULL ,
                img VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";

    if ($conn->query($image_sql) === false) return false;
}
