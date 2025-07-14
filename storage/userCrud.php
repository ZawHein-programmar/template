<?php
function save_user($conn,  $name,  $email,  $password,  $address = "",  $phone = "",  $profile = "", int $role = 1): mixed
{
    $sql = "INSERT INTO `user` (`user_name`, `email`, `password`, `address`, `phone`, `profile`, `role`) VALUES ('$name', '$email', '$password', '$address', '$phone', '$profile', $role)";
    return $conn->query($sql);
}

function get_user_with_email($mysql, $email)
{
    $sql = "SELECT * FROM `user` WHERE `email` = '$email' ";
    $user = $mysql->query($sql);
    return $user->fetch_assoc();
}
function delete_user($mysql, $deleteId)
{
    try {
        $sql = "DELETE FROM `user` WHERE `user_id` = $deleteId";
        return $mysql->query($sql);
    } catch (Exception $e) {
        return "Internal server error";
    }
}
function get_all_users($mysql)
{
    $sql = "SELECT * FROM `member`";
    return $mysql->query($sql);
}
function get_user_with_offset($mysql, $offset, $limit)
{
    $sql = "SELECT * FROM user LIMIT $limit OFFSET $offset";
    return $mysql->query($sql);
}

function get_user_with_id($mysql, $id)
{
    $sql = "SELECT * FROM `user` WHERE `id` = $id";
    $user = $mysql->query($sql);
    return $user->fetch_assoc();
}
