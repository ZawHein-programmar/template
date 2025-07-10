<?php
require_once("./storage/db.php");
require_once("./storage/userCrud.php");
if (isset($_COOKIE['user'])) {
    header("location:./home.php");
    exit;
}
$name = $nameErr = "";
$email = $emailErr = "";
$password = $passwordErr = "";
$confirmPassword = $confirmPasswordErr = "";
$invalid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirmPassword = htmlspecialchars(trim($_POST['confirmPassword']));

    if ($name == "") {
        $nameErr = "Enter your name...";
        $invalid = false;
    } else {
        if (!preg_match('/^[A-Za-z][A-Za-z0-9 ]*$/', $name)) {
            $nameErr = "Invalid name";
            $invalid = false;
        }
    }
    if ($email == "") {
        $emailErr = "Enter your email...";
        $invalid = false;
    } else {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $emailErr = "Please enter valid email format!";
            $invalid = false;
        }
    }

    if ($password == "") {
        $passwordErr = "Enter your password...";
        $invalid = false;
    } else {
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,20}$/', $password)) {
            $passwordErr = "Invalid password format (Eg.Hein@123)";
            $invalid = false;
        }
    }
    if ($confirmPassword == "") {
        $confirmPasswordErr = "Confirm Password cann't be blank!";
        $invalid = false;
    }
    if ($confirmPassword != $password) {
        $confirmPasswordErr = "Confirm password does not match to password!";
        $invalid = false;
    }
    if ($invalid) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $status = save_user($conn, $name, $email, $hashedPassword);
        if ($status) {
            $user = get_user_with_email($conn, $email);
            setcookie("user", json_encode($user), time() + 60 * 60 * 24 * 30, "/");
            header("Location:./home.php");
        } else {
            echo "There is an error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 15px;
            background-color: rgb(105, 174, 239);
        }

        .btn-success {
            border-radius: 25px;
        }

        .form-control {
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card w-50 shadow-lg p-4">
            <h3 class="text-center text-white mb-4">Register</h3>
            <form method="post">
                <div class="form-group mb-3">
                    <label for="name" class="form-label text-white">Name</label>
                    <input type="text" class="form-control py-2" name="name" id="name" value="<?= $name ?>" placeholder="Enter your name">
                    <div style="height: 10px;" class="text-danger"><b><?= $nameErr ?></b></div>
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="form-label text-white">Email</label>
                    <input type="email" class="form-control py-2" name="email" value="<?= $email ?>" id="email" placeholder="Enter your email">
                    <div style="height: 10px;" class="text-danger"><b><?= $emailErr ?></b></div>
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="form-label text-white">Password</label>
                    <input type="password" class="form-control py-2" value="<?= $password ?>" name="password" id="password" placeholder="Enter your password">
                    <div style="height: 10px;" class="text-danger"><b><?= $passwordErr ?></b></div>
                </div>

                <div class="form-group mb-3">
                    <label for="confirmPassword" class="form-label text-white">Confirm Password</label>
                    <input type="password" class="form-control py-2" name="confirmPassword" value="<?= $confirmPassword ?>" id="confirmPassword" placeholder="Re-enter your password">
                    <div style="height: 10px;" class="text-danger"><b><?= $confirmPasswordErr ?></b></div>
                </div>

                <div class="form-group  text-center">
                    <button type="submit" class="btn btn-success w-50 py-3 mt-4">Register</button>
                </div>
                <div class="form-group mt-4 text-center">
                    <p>Don't have an account? <a href="./login.php">Login Here</a></p>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>