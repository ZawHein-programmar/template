<?php require_once("./auth/checkAuth.php");
if ($user['role'] == 1) {
    header("location:./user/index.php");
} elseif ($user['role'] == 2) {
    header("location:./admin/index.php");
}
