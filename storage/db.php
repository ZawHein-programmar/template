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
if ($conn->query($sql) === TRUE) {
    // echo "Database created successfully or already exists.<br>";
} else {
    die("Error creating database: " . $conn->error . "<br>");
}

// Select the database
$conn->select_db($dbname);

// Create User Table
$sql = "CREATE TABLE IF NOT EXISTS `user` (
    `user_id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_name` VARCHAR(70) NOT NULL,
    `email` VARCHAR(70) UNIQUE NOT NULL,
    `password` VARCHAR(220) NOT NULL,
    `address` VARCHAR(220),
    `phone` VARCHAR(50),
    `profile` LONGTEXT,
    `role` INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if (!$conn->query($sql)) {
    die("Error creating user table: " . $conn->error . "<br>");
}

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
    FOREIGN KEY (sender_id) REFERENCES `user`(user_id),
    FOREIGN KEY (receiver_id) REFERENCES `user`(user_id)
)";
if (!$conn->query($sql)) {
    die("Error creating Parcels table: " . $conn->error . "<br>");
}

// Create Branches Table
$sql = "CREATE TABLE IF NOT EXISTS Branches (
    branch_id INT AUTO_INCREMENT PRIMARY KEY,
    branch_name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!$conn->query($sql)) {
    die("Error creating Branches table: " . $conn->error . "<br>");
}

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
if (!$conn->query($sql)) {
    die("Error creating BranchTransfers table: " . $conn->error . "<br>");
}

// Create Payments Table
$sql = "CREATE TABLE IF NOT EXISTS Payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    parcel_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method ENUM('Cash', 'Card', 'Online') NOT NULL DEFAULT 'Cash',
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parcel_id) REFERENCES Parcels(parcel_id)
)";
if (!$conn->query($sql)) {
    die("Error creating Payments table: " . $conn->error . "<br>");
}

// Data Seeding
// $conn->begin_transaction();
// try {
//     // Insert Users
//     $users = [
//         ["John Doe", "john@example.com", password_hash('password123', PASSWORD_DEFAULT), "123 Main St", "1234567890", null, 1],
//         ["Jane Smith", "jane@example.com", password_hash('password123', PASSWORD_DEFAULT), "456 Elm St", "0987654321", null, 2],
//         ["Alice Brown", "alice@example.com", password_hash('password123', PASSWORD_DEFAULT), "789 Pine St", "1122334455", null, 2]
//     ];
//     $stmt = $conn->prepare("INSERT INTO `user` (user_name, email, password, address, phone, profile, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
//     foreach ($users as $user) {
//         $stmt->bind_param("ssssssi", $user[0], $user[1], $user[2], $user[3], $user[4], $user[5], $user[6]);
//         $stmt->execute();
//     }
//     $stmt->close();

//     // Insert Branches
//     $branches = [
//         ["Yangon Branch", "Yangon"],
//         ["Mandalay Branch", "Mandalay"],
//         ["Naypyidaw Branch", "Naypyidaw"]
//     ];
//     $stmt = $conn->prepare("INSERT INTO Branches (branch_name, location) VALUES (?, ?)");
//     foreach ($branches as $branch) {
//         $stmt->bind_param("ss", $branch[0], $branch[1]);
//         $stmt->execute();
//     }
//     $stmt->close();

//     // Insert Parcels
//     $parcels = [
//         ["TRK-001", 2.5, 3000.00, 1, 2],
//         ["TRK-002", 1.2, 1500.00, 2, 3],
//         ["TRK-003", 3.0, 4500.00, 3, 1]
//     ];
//     $stmt = $conn->prepare("INSERT INTO Parcels (tracking_number, weight, price, sender_id, receiver_id) VALUES (?, ?, ?, ?, ?)");
//     foreach ($parcels as $parcel) {
//         $stmt->bind_param("sdiis", $parcel[0], $parcel[1], $parcel[2], $parcel[3], $parcel[4]);
//         $stmt->execute();
//     }
//     $stmt->close();

//     // Insert BranchTransfers
//     $transfers = [
//         [1, 1, 2, "In Transit"],
//         [2, 2, 3, "Arrived"],
//         [3, 3, 1, "In Transit"]
//     ];
//     $stmt = $conn->prepare("INSERT INTO BranchTransfers (parcel_id, from_branch_id, to_branch_id, status) VALUES (?, ?, ?, ?)");
//     foreach ($transfers as $transfer) {
//         $stmt->bind_param("iiis", $transfer[0], $transfer[1], $transfer[2], $transfer[3]);
//         $stmt->execute();
//     }
//     $stmt->close();

//     // Insert Payments
//     $payments = [
//         [1, 3000.00, "Cash"],
//         [2, 1500.00, "Card"],
//         [3, 4500.00, "Online"]
//     ];
//     $stmt = $conn->prepare("INSERT INTO Payments (parcel_id, amount, payment_method) VALUES (?, ?, ?)");
//     foreach ($payments as $payment) {
//         $stmt->bind_param("ids", $payment[0], $payment[1], $payment[2]);
//         $stmt->execute();
//     }
//     $stmt->close();

//     // Commit the transaction
//     $conn->commit();
//     echo "Data seeding completed successfully!<br>";

// } catch (Exception $e) {
//     $conn->rollback();
//     die("Data seeding failed: " . $e->getMessage() . "<br>");
// }

// Close connection
// $conn->close();
?>
