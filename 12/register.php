<?php
require 'databaserequire.php';
require 'common.php';


$name = '';
$gmail = '';
$password = '';
$name_error = '';
$email_error = '';
$password_error = '';
$error = false;

if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //name validation
    if (strlen($name) < 1) {
        $error = true;
        $name_error = "You must fill your name.";
    } else if (strlen($name) > 30) {
        $error = true;
        $name_error = "Your name is too long.";
    } else {
        $name_error = "Success";
    }

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
        $sql = "INSERT INTO `user` (`username`, `email`, `password`, `phone`)
                VALUES ('$name', '$email', '$password', '$phone')";

        $result = $mysql->query($sql);

        if ($result) {
            var_dump('hello bro congrats.');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<?php
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
                    <h1 class="text-lg text-white mt-2">New User Register</h1>
                </div>
            </div>
        </div>
    </section>

    <body>
        <div class="container">
            <div class="card-body pt-5">

                <a class="text-center" href="index.html">
                    <h1 class="text-color">Register Here</h1>
                </a>

                <form class="mt-5 mb-5 login-input" method="POST">
                    <div class="form-group">
                        <label for="success_insert" class="text-success"><?= $success_insert ?></label>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="Name">
                        <label for="name" class="text-danger"><?= $name_error ?></label>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Email">
                        <label for="name" class="text-danger"><?= $email_error ?></label>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <label for="name" class="text-danger"><?= $password_error ?></label>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="phone" placeholder="Phone">
                    </div>
                    <input type="hidden" name="form_sub" value="1">
                    <button class="btn btn-dark login-form__btn submit w-100">Sign Up</button>
                </form>
                <p class="mt-5 login-form__footer">Have account <a href="<?= $admin_base_url ?>login.php" class="text-primary">Sign in </a> now</p>
                </p>
            </div>
        </div>
</div>

</body>

</html>
<?=
require 'footer.php';
?>