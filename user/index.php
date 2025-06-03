<?php
$user = json_decode($_COOKIE["user"], true);
$user_role = $user['role'] ?? 0;
if ($user_role != 1) {
    header("location:../home.php");
    exit;
}
?>
<?php
require_once('../userLayout/header1.php'); ?>

<div class="container-fluid mt-4">
    <h1>Product List</h1>
</div>

<?php include_once('../userLayout/footer.php'); ?>