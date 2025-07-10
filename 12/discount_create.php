<?php
ob_start();
require 'databaserequire.php';
require 'common.php';
require "central_function.php";

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
        $name_error = "Your name is too long.";
    } else {
        $name_error = "Success name.";
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

        $result = insertData('discount', $mysql, $data);
        var_dump($result);

        if ($result) {
            $url = $admin_base_url . 'discount_create.php?success=Created Success';
            header("Location: $url");
            exit;
        } else {
            var_dump("hello");
            $url = $admin_base_url . 'discount_create.php?error=Error In Insertion';
            header("Location: $url");
            exit;
        }
    }
}
require 'header.php';
?>

<div class="main-wrapper ">
    <section class="page-title bg-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="index.php"
                                class="text-sm letter-spacing text-white text-uppercase font-weight-bold">Home</a>
                        </li>
                        <li class="list-inline-item"><span class="text-white">|</span></li>
                        <li class="list-inline-item"><a href="#"
                                class="text-color text-uppercase text-sm letter-spacing">Team</a></li>
                    </ul>
                    <h1 class="text-lg text-white mt-2">Discount Create</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="card-body pt-5">

            <a class="text-center" href="member_create.php">
                <h1 class="text-color">Create Member</h1>
            </a>

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
            <p class="mt-5 login-form__footer">Have account <a href="<?= $admin_base_url ?>login.php" class="text-primary">Sign in </a> now</p>
            </p>
        </div>
    </div>
</div>

<?php
require 'footer.php';
ob_end_flush();
?>