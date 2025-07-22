<?php require_once("./auth/checkAuth.php");
if ($user['role'] == 'staff') {
    header("location:./admin/index.php");
} elseif ($user['role'] == 'admin') {
    header("location:./admin/index.php");
} elseif ($user['role'] == 'user') {
    header("location:./user/index.php");
}
