<?php
$current_user = json_decode($_COOKIE["user"], true);
$user_role = $current_user['role'] ?? 0;
if ($user_role != "admin") {
    header("location:../home.php");
    exit;
}
?>

<?php

require '../storage/db.php';
require '../storage/central_function.php';
// var_dump('hello');
// exit;

$error = false;
$name_of_package = '';
$percentage = '';

if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_of_package = $_POST['name_of_package'];
    $percentage = $_POST['percentage'];

    //package name validation
    if ($name_of_package == '' && strlen($name_of_package) == 0) {
        $error = true;
        $name_error = "You need to type your name.";
    } else if (strlen($name_of_package) > 50) {
        $error = true;
        $name_error = "Package name is too long.";
    } else {
        $name_error = "Success create package.";
    }

    //percentage validation
    if (strlen($percentage) == 0) {
        $error = true;
        $percentage_error = "Your must fill discount percnetage.";
    }

    if (!$error) {

        $data = [
            'name_of_package' => $name_of_package,
            'percentage' => $percentage
        ];

        $result = insertData('discount', $conn, $data);
        var_dump($result);

        if ($result) {
            $url =  '../admin/discount_list.php?success=Created Success';
            header("Location: $url");
            exit;
        } else {
            var_dump("hello");
            $url = '../admin/discount_create.php?error=Error In Insertion';
            header("Location: $url");
            exit;
        }
    }
}

?>

<?php
require_once('../adminLayout/header1.php'); ?>

<div class="container mt-4 fade-in-up">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-percentage me-2"></i>Create Discount Package</h3>
        </div>
        <div class="card-body">
            <form class="mt-3" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name_of_package" class="form-label">
                            <i class="fas fa-tag me-2"></i>Package Name
                        </label>
                        <input type="text" class="form-control" id="name_of_package" name="name_of_package" value="<?= $name_of_package ?>" placeholder="Enter package name">
                        <?php if (isset($name_error) && $name_error !== "Success create package.") { ?>
                            <div class="text-danger small mt-1"><?= $name_error ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="percentage" class="form-label">
                            <i class="fas fa-percent me-2"></i>Discount Percentage
                        </label>
                        <input type="number" class="form-control" id="percentage" name="percentage" value="<?= $percentage ?>" placeholder="Enter discount percentage" min="0" max="100" step="0.01">
                        <div class="form-text">Enter percentage between 0-100</div>
                        <?php if (isset($percentage_error) && $percentage_error) { ?>
                            <div class="text-danger small mt-1"><?= $percentage_error ?></div>
                        <?php } ?>
                    </div>
                </div>

                <input type="hidden" name="form_sub" value="1">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Create Discount Package
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('../adminLayout/footer.php'); ?>

<script>
    // Add success message handling
    <?php if (isset($_GET['success'])) { ?>
        Swal.fire({
            title: 'Success!',
            text: '<?= $_GET['success'] ?>',
            icon: 'success',
            confirmButtonText: 'OK',
            background: 'rgba(255, 255, 255, 0.1)',
            backdrop: 'rgba(0, 0, 0, 0.3)',
            backdropFilter: 'blur(10px)',
            customClass: {
                popup: 'glass-popup'
            }
        });
    <?php } ?>

    <?php if (isset($_GET['error'])) { ?>
        Swal.fire({
            title: 'Error!',
            text: '<?= $_GET['error'] ?>',
            icon: 'error',
            confirmButtonText: 'OK',
            background: 'rgba(255, 255, 255, 0.1)',
            backdrop: 'rgba(0, 0, 0, 0.3)',
            backdropFilter: 'blur(10px)',
            customClass: {
                popup: 'glass-popup'
            }
        });
    <?php } ?>
</script>