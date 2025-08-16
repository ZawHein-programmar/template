<?php
$current_user = json_decode($_COOKIE["user"], true);
$user_role = $current_user['role'] ?? 0;
if ($user_role != "admin") {
    header("location:../home.php");
    exit;
}
require '../storage/db.php';
require '../storage/central_function.php';

$error = false;
$name_of_package = '';
$percentage = '';

if (isset($_GET['id']) && $_GET['id'] !== '') {
    $id = $_GET['id'];
    $selectData = select_data('discount', $conn, "*", "WHERE `discount_id`='$id'");

    if ($selectData->num_rows > 0) {
        $data = $selectData->fetch_assoc();
        $name = $data['name'];
    } else {
        $url = "./discount_list.php?error=Id Not Found";
        header("Location: $url");
    }
    header("Location: $url");
}


if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_of_package = $_POST['name_of_package'];
    $percentage = $_POST['percentage'];

    //name validation
    if ($name_of_package == '' && strlen($name_of_package) == 0) {
        $error = true;
        $name_of_package_error = "You need to type your package name.";
    } else if (strlen($name_of_package) > 50) {
        $error = true;
        $name_of_package_error = "Your package name is too long.";
    } else {
        $name_of_package_error = "Success package name.";
    }


    //address validation
    if ($percentage == '' && strlen($percentage) == 0) {
        $error = true;
        $percentage_error = "You must fill percentage.";
    } else {
        $percentage_error = "Complete.";
    }

    if (!$error) {
        $data = [
            'name_of_package' => $name_of_package,
            'percentage' => $percentage
        ];
        $where = [
            'discount_id' => $id
        ];

        // updating members details
        $result = updateData('discount', $conn, $data, $where);

        if ($result) {
            $url = './discount_list.php?success=Update Success';
            header("Location: $url");
            exit;
        } else {
            $error = true;
            $error_message = "Discount Update Fail.";
        }
    }
}

?>

<?php
require_once('../adminLayout/header1.php'); ?>

<div class="d-flex justify-content-end mt-3">
    <button onclick="window.history.back()" class="btn btn-glass">
        <i class="fa-solid fa-arrow-left me-2"></i>Back
    </button>
</div>
<div class="container-fluid mt-5" style="width: 50%; margin: 0px auto;">
    <h3>Edit Discount Package</h3>
    <form class="mt-5 mb-5 login-input" action="<?= './discount_edit.php?id=' . $id ?>" method="POST">
        <div class="form-group">
            <input type="text" class="form-control" name="name_of_package" value="<?= $data['name_of_package'] ?>" placeholder="Package Name">
            <label for="name_of_package" class="text-danger"><?= $name_of_package_error ?></label>
        </div>
        <div class="form-group">
            <input type="percentage" class="form-control" name="percentage" value="<?= $data['percentage'] ?>" placeholder="Percentage">
            <label for="name" class="text-danger"><?= $percentage_error ?></label>
        </div>
        <input type="hidden" name="form_sub" value="1">
        <button class="btn btn-dark login-form__btn submit w-100">Submit</button>
    </form>
</div>

<?php include_once('../adminLayout/footer.php'); ?>