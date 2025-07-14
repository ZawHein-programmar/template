<?php
$current_user = json_decode($_COOKIE["user"], true);
$user_role = $current_user['role'] ?? 0;
if ($user_role != "admin") {
    header("location:../home.php");
    exit;
}
?>

<?php

require '../storage/db.php';
require '../storage/central_function.php';
// var_dump('hello');
// exit;

$error = false;
$name_of_package = '';
$percentage = '';

if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_of_package = $_POST['name_of_package'];
    $percentage = $_POST['percentage'];

    //package name validation
    if ($name_of_package == '' && strlen($name_of_package) == 0) {
        $error = true;
        $name_error = "You need to type your name.";
    } else if (strlen($name_of_package) > 50) {
        $error = true;
        $name_error = "Package name is too long.";
    } else {
        $name_error = "Success create package.";
    }

    //percentage validation
    if (strlen($percentage) == 0) {
        $error = true;
        $percentage_error = "Your must fill discount percnetage.";
    }

    if (!$error) {

        $data = [
            'name_of_package' => $name_of_package,
            'percentage' => $percentage
        ];

        $result = insertData('discount', $conn, $data);
        var_dump($result);

        if ($result) {
            $url =  '../admin/discount_create.php?success=Created Success';
            header("Location: $url");
            exit;
        } else {
            var_dump("hello");
            $url = '../admin/discount_create.php?error=Error In Insertion';
            header("Location: $url");
            exit;
        }
    }
}

?>

<?php
require_once('../adminLayout/header1.php'); ?>

<div class="container-fluid mt-5" style="width: 50%; margin: 0px auto;">
    <div class="card-body pt-5">
        <h3>Discount Create</h3>

        <form class="mt-5 mb-5 login-input" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="form-group">
                <input type="text" class="form-control" name="name_of_package" placeholder="Package Name">
                <label for="name_of_package" class="text-danger"><?= $name_of_package_error ?></label>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="percentage" placeholder="Percentage">
                <label for="percentage" class="text-danger"><?= $percentage_error ?></label>
            </div>
            <input type="hidden" name="form_sub" value="1">
            <button class="btn btn-dark login-form__btn submit w-100">Submit</button>
        </form>
    </div>
</div>

<?php include_once('../adminLayout/footer.php'); ?>