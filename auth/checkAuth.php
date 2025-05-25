<?php

$user = json_decode($_COOKIE["user"], true);
if (!$user) {
    // header("Location:../index.php?invalid=Please login first!");
    header("Location:../login.php");
    echo "Hello";
    die();
} else {
    $url = $_SERVER['REQUEST_URI'];
    $arr = explode('/', $url);
    $code = 0;
    if ($arr[count($arr) - 2] !== "Template") {
        $role_name = $arr[count($arr) - 2];
        switch ($role_name) {
            case 'admin':
                $code = 1;
                break;
            case 'cashier':
                $code = 2;
                break;
            case 'kitchen':
                $code = 3;
                break;
            case 'waiter':
                $code = 4;
                break;
            default:
                $code = 0;
                break;
        }
    }
    if ($code != $user['role']) {
        header("location:../401.html");
    }
}


if (isset($_POST["logout"])) {
    setcookie("user", "", -1, "/");
    header("location:../index.php");
}
