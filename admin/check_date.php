<?php
require '../storage/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);
    $date = $data['date'];
    $sql = "SELECT * FROM `discount_detail` INNER JOIN `discount` ON `discount`.`discount_id` = `discount_detail`.`discount_id`  WHERE `discount_detail`.`start_date` <= '$date' AND `discount_detail`.`end_date` >= '$date'";
    $result = $conn->query($sql);
    $discounts = [];

    while ($row = $result->fetch_assoc()) {
        $discounts[] = $row;
    }

    echo json_encode(['date' => $discounts, 'status' => 'success']);
}
