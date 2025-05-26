<?php
if (isset($_COOKIE['user'])) {
    header("location:./home.php");
    exit;
}
$password_err = "";
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
            background-color: rgb(254, 254, 254);
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
            <h3 class="text-center text-dark mb-4">Login</h3>
            <form action="" method="post">
                <div class="form-group mb-3">
                    <label for="email" class="form-label text-dark">Email</label>
                    <input type="email" class="form-control py-2" name="email" id="email" placeholder="Enter your email">
                    <div class="text-danger" style="font-size:12px;"><?= $password_err ?></div>
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="form-label text-dark">Password</label>
                    <input type="password" class="form-control py-2" name="password" id="password" placeholder="Enter your password">
                </div>

                <div class="form-group mt-4 text-center">
                    <button type="submit" class="btn btn-success w-50 py-2">Login</button>
                </div>
                <div class="form-group mt-4 text-center">
                    <p>Don't have an account? <a href="./register.php">Register Here</a></p>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>