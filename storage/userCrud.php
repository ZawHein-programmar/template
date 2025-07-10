<?php
function save_user($mysqli,  $name,  $email,  $password,  $address = "",  $phone = "",  $profile = "", int $role = 1): mixed
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
function delete_user($mysqli, $deleteId)
{
    try {
        $sql = "DELETE FROM `user` WHERE `user_id` = $deleteId";
        return $mysqli->query($sql);
    } catch (Exception $e) {
        return "Internal server error";
    }
}
function get_all_users($mysqli)
{
    $sql = "SELECT * FROM `user`";
    return $mysqli->query($sql);
}
function get_user_with_offset($mysqli, $offset, $limit)
{
    $sql = "SELECT * FROM user LIMIT $limit OFFSET $offset";
    return $mysqli->query($sql);
}

function get_user_with_id($mysqli, $id)
{
    $sql = "SELECT * FROM `user` WHERE `id` = $id";
    $user = $mysqli->query($sql);
    return $user->fetch_assoc();
}
