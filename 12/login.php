<?php
session_start();
require 'databaserequire.php';
require 'common.php';
require 'central_function.php';

$email = '';
$password = '';
$error = false;
$success = $_GET['success'] ? $_GET['success']  : '';
if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //email validation
    $email_format = "/^[\w\-\.]+@([\w\-]+\.)+[a-zA-Z]{2,7}$/";
    if ($email == '' && strlen($email) == 0) {
        $error = true;
        $email_error = "Your must fill your email.";
    } else if (!preg_match($email_format, $email)) {
        $error = true;
        $email_error = "Your email format is wrong.";
    } else if (strlen($email) > 100) {
        $error = true;
        $email_error = "Your email is too long.";
    } else {
        $email_error = "Success email.";
    }

    //password validation
    $password_format = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$/";
    if ($password == '') {
        $error = true;
        $password_error = "Your need to type your password.";
    } else if (!preg_match($password_format, $password)) {
        $error = true;
        $password_error = "Week password format.";
    } else if (strlen($password) > 30) {
        $error = true;
        $password_error = "Your password is too long.";
    } else {
        $password_error = "Success password.";
    }

    if (!$error) {
        $result = select_data('user', $mysql, '*', 'where $email = email');
        var_dump($result);
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
                    <h1 class="text-lg text-white mt-2">Login</h1>
                </div>
            </div>
        </div>
    </section>

    <body>
        <div class="container">
            <div class="card-body pt-5">

                <a class="text-center" href="index.html">
                    <h1 class="text-color">Sign In</h1>
                </a>

                <form class="mt-5 mb-5 login-input" method="POST">
                    <?php if ($success !== '') { ?>
                        <div class="alert alert-success">
                            <?= $success ?>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Email">
                        <label for="name" class="text-danger"><?= $email_error ?></label>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <label for="name" class="text-danger"><?= $password_error ?></label>
                    </div>
                    <input type="hidden" name="form_sub" value="1">
                    <button class="btn btn-dark login-form__btn submit w-100">Login</button>
                </form>
                <p class="mt-5 login-form__footer">Have account <a href="<?= $admin_base_url ?>login.php" class="text-primary">Sign in </a> now</p>
                </p>
            </div>
        </div>
</div>

<?=
require 'footer.php';
?>

</body>

</html>