<?php
$user = json_decode($_COOKIE["user"], true);
if (!$user) {
    header("Location:/GYM/login.php");
    exit;
} else {
    $url = $_SERVER['REQUEST_URI'];
    $arr = explode('/', $url);
    $code = 0;
    if ($arr[count($arr) - 2] !== "GYM") {
        $role_name = $arr[count($arr) - 2];
        switch ($role_name) {
            case 'admin':
                $code = 2;
                break;
            default:
                $code = 1;
                break;
        }
    }
    if ($code != $user['role']) {
        header("location:../401.html");
    }
}


if (isset($_POST["logout"])) {
    setcookie("user", "", -1, "/");
    header("location:./login.php");
}
