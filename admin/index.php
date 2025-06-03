<?php
$current_user = json_decode($_COOKIE["user"], true);
$user_role = $current_user['role'] ?? 0;
if ($user_role != 2) {
    header("location:../home.php");
    exit;
}
?>

<?php
require_once('../adminLayout/header1.php'); ?>

<div class="container-fluid mt-4">
    <?php
    require_once('./user.php'); ?>
</div>

<?php include_once('../adminLayout/footer.php'); ?>