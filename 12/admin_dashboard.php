<?php
session_start();
require_once("common.php"); // session check
require_once("databaserequire.php"); // database connection

// Get total members
$member_result = $mysql->query("SELECT COUNT(*) as total_members FROM `member`");
$member_count = $member_result->fetch_assoc()['total_members'];

// Get total trainers
$trainer_result = $mysql->query("SELECT COUNT(*) as total_trainers FROM `trainer`");
$trainer_count = $trainer_result->fetch_assoc()['total_trainers'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <?php include("header.php"); ?>

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
                    <h1 class="text-lg text-white mt-2">Dashboard</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-4">
        <h2 class="mb-4">Admin Dashboard</h2>

        <div class="row">
            <div class="col-md-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Members</h5>
                        <p class="card-text display-4"><?php echo $member_count; ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Trainers</h5>
                        <p class="card-text display-4"><?php echo $trainer_count; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>
</body>

</html>