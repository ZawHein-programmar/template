<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parcel_tracking_system";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql)) {
    return true;
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db($dbname);

// Create Users Table
$sql = "CREATE TABLE IF NOT EXISTS Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

// Create Parcels Table
$sql = "CREATE TABLE IF NOT EXISTS Parcels (
    parcel_id INT AUTO_INCREMENT PRIMARY KEY,
    tracking_number VARCHAR(50) UNIQUE NOT NULL,
    weight FLOAT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    status ENUM('Pending', 'In Transit', 'Delivered') NOT NULL DEFAULT 'Pending',
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES Users(user_id),
    FOREIGN KEY (receiver_id) REFERENCES Users(user_id)
)";
$conn->query($sql);

// Create Branches Table
$sql = "CREATE TABLE IF NOT EXISTS Branches (
    branch_id INT AUTO_INCREMENT PRIMARY KEY,
    branch_name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

// Create BranchTransfers Table
$sql = "CREATE TABLE IF NOT EXISTS BranchTransfers (
    transfer_id INT AUTO_INCREMENT PRIMARY KEY,
    parcel_id INT NOT NULL,
    from_branch_id INT NOT NULL,
    to_branch_id INT NOT NULL,
    transfer_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('In Transit', 'Arrived') NOT NULL DEFAULT 'In Transit',
    FOREIGN KEY (parcel_id) REFERENCES Parcels(parcel_id),
    FOREIGN KEY (from_branch_id) REFERENCES Branches(branch_id),
    FOREIGN KEY (to_branch_id) REFERENCES Branches(branch_id)
)";
$conn->query($sql);

// Create Payments Table
$sql = "CREATE TABLE IF NOT EXISTS Payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    parcel_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method ENUM('Cash', 'Card', 'Online') NOT NULL DEFAULT 'Cash',
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parcel_id) REFERENCES Parcels(parcel_id)
)";
$conn->query($sql);

// Data Seeding
// echo "Seeding data...<br>";

// Insert Users
$users = [
    ["John Doe", "1234567890", "123 Main St"],
    ["Jane Smith", "0987654321", "456 Elm St"],
    ["Alice Brown", "1122334455", "789 Pine St"]
];
foreach ($users as $user) {
    $sql = "INSERT INTO Users (name, phone_number, address) VALUES (
        '{$user[0]}', '{$user[1]}', '{$user[2]}'
    )";
    $conn->query($sql);
}

// Insert Branches
$branches = [
    ["Yangon Branch", "Yangon"],
    ["Mandalay Branch", "Mandalay"],
    ["Naypyidaw Branch", "Naypyidaw"]
];
foreach ($branches as $branch) {
    $sql = "INSERT INTO Branches (branch_name, location) VALUES (
        '{$branch[0]}', '{$branch[1]}'
    )";
    $conn->query($sql);
}

// Insert Parcels
$parcels = [
    ["TRK-001", 2.5, 3000.00, 1, 2],
    ["TRK-002", 1.2, 1500.00, 2, 3],
    ["TRK-003", 3.0, 4500.00, 3, 1]
];
foreach ($parcels as $parcel) {
    $sql = "INSERT INTO Parcels (tracking_number, weight, price, sender_id, receiver_id) VALUES (
        '{$parcel[0]}', {$parcel[1]}, {$parcel[2]}, {$parcel[3]}, {$parcel[4]}
    )";
    $conn->query($sql);
}

// Insert BranchTransfers
$transfers = [
    [1, 1, 2, "In Transit"],
    [2, 2, 3, "Arrived"],
    [3, 3, 1, "In Transit"]
];
foreach ($transfers as $transfer) {
    $sql = "INSERT INTO BranchTransfers (parcel_id, from_branch_id, to_branch_id, status) VALUES (
        {$transfer[0]}, {$transfer[1]}, {$transfer[2]}, '{$transfer[3]}'
    )";
    $conn->query($sql);
}

// Insert Payments
$payments = [
    [1, 3000.00, "Cash"],
    [2, 1500.00, "Card"],
    [3, 4500.00, "Online"]
];
foreach ($payments as $payment) {
    $sql = "INSERT INTO Payments (parcel_id, amount, payment_method) VALUES (
        {$payment[0]}, {$payment[1]}, '{$payment[2]}'
    )";
    $conn->query($sql);
}

// echo "Data seeding completed!<br>";

// Close connection
$conn->close();
?>
