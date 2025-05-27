<?php
$user = json_decode($_COOKIE["user"], true);
$user_role = $user['role'] ?? 0;
if ($user_role != 2) {
    header("location:../home.php");
    exit;
}
?>
<h1>This is Admin Page</h1>