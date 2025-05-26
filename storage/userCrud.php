<?php
function save_user($mysqli,  $name,  $email,  $password,  $address = "",  $phone = "",  $profile = "", int $role = 2): mixed
{
    $sql = "INSERT INTO `user` (`user_name`, `email`, `password`, `address`, `phone`, `profile`, `role`) VALUES ('$name', '$email', '$password', '$address', '$phone', '$profile', $role)";
    return $mysqli->query($sql);
}

function get_user_with_email($mysqli, $email)
{
    $sql = "SELECT * FROM `user` WHERE `email` = '$email' ";
    $user = $mysqli->query($sql);
    return $user->fetch_assoc();
}
