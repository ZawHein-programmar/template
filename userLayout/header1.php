<?php
$status = false;
if (isset($_COOKIE['user'])) {
    $status = true;
}
if (isset($_POST['logout'])) {
    setcookie("user", '', -1, "/");
    header('Location:../index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Sidebar Toggle</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Sidebar styles */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #343a40;
            color: white;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar.hide {
            left: -250px;
        }

        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        .sidebar-backdrop.active {
            display: block;
        }

        .sidebar.show-mobile {
            left: 0;
        }

        .content {
            margin-left: 250px;
            transition: all 0.3s;
        }

        .content.full {
            margin-left: 0;
        }

        /* Navbar styles */
        .search-container {
            background-color: #f8f9fa;
            padding: 10px 0;
        }

        .desktop-search {
            max-width: 500px;
            margin: 0 auto;
        }

        @media (max-width: 767.98px) {
            .sidebar {
                left: -250px;
            }

            .content {
                margin-left: 0;
            }

            .desktop-nav-items {
                display: none;
            }

            .desktop-search {
                display: none;
            }
        }

        @media (min-width: 768px) {
            .mobile-nav-items {
                display: none;
            }

            .mobile-search {
                display: none;
            }

            .navbar-content {
                width: 100%;
            }
        }

        .sidebarNavBar .dropdown-menu {
            background-color: #495057;
        }

        .sidebarNavBar .dropdown-item {
            color: rgba(255, 255, 255, 0.8);
        }

        .sidebarNavBar .dropdown-item:hover {
            background-color: #6c757d;
            color: white;
        }

        /* Cart badge styles */
        .cart-icon-container {
            position: relative;
            display: inline-block;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 10px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #profileDropdown::after {
            display: none;
        }
    </style>
</head>

<body>
    <?php include_once('../userLayout/sidebar.php'); ?>

    <div class="content" id="content">
        <?php include_once('../userLayout/navbar.php'); ?>