<?php
require '../storage/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['payment_id'])) {
        $payment_id = $_GET['payment_id'];
        $sql = "SELECT * FROM `payment` py 
                JOIN member_class mc ON py.`member_class_id` = mc.`member_class_id` 
                JOIN member m ON mc.`member_id` = m.`member_id` 
                JOin class_trainer ct on mc.`class_trainer_id` = ct.`class_trainer_id` 
                JOIN class c on `ct`.`class_id` = c.class_id 
                JOIn trainer t on ct.`trainer_id` = t.`trainer_id` 
                join discount_detail dd on py.`discount_detail_id` = dd.`discount_detail_id`
                join discount d on dd.`discount_id` = d.`discount_id`
                WHERE py.`payment_id` = '$payment_id'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode(['payment' => $row, 'status' => 'success']);
        } else {
            echo json_encode(['error' => 'Payment not found', 'status' => 'error']);
        }
    } else {
        echo json_encode(['error' => 'Payment ID is required', 'status' => 'error']);
    }
}
