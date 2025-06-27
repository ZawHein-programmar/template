<?php
function save_user($conn,  $name,  $email,  $password,  $address = "",  $phone = "",  $profile = "", int $role = 2): mixed
{
    $sql = "INSERT INTO `user` (`user_name`, `email`, `password`, `address`, `phone`, `profile`, `role`) VALUES ('$name', '$email', '$password', '$address', '$phone', '$profile', $role)";
    return $conn->query($sql);
}

function get_user_with_email($conn, $email)
{
    $sql = "SELECT * FROM `user` WHERE `email` = '$email' ";
    $user = $conn->query($sql);
    return $user->fetch_assoc();
}
function delete_user($conn, $deleteId)
{
    try {
        $sql = "DELETE FROM `user` WHERE `user_id` = $deleteId";
        return $conn->query($sql);
    } catch (Exception $e) {
        return "Internal server error";
    }
}
function get_all_users($conn)
{
    $sql = "SELECT * FROM `user`";
    return $conn->query($sql);
}
function get_user_with_offset($conn, $offset, $limit)
{
    $sql = "SELECT * FROM user LIMIT $limit OFFSET $offset";
    return $conn->query($sql);
}

function get_user_with_id($conn, $id)
{
    $sql = "SELECT * FROM `user` WHERE `id` = $id";
    $user = $conn->query($sql);
    return $user->fetch_assoc();
}
