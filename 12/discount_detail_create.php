<?php
ob_start();
require 'databaserequire.php';
require 'common.php';
require "central_function.php";

$error = false;
$name_of_package = '';
$day_error = '';

$select_discount = select_data('discount', $mysql, '*', '', '');

$success = $_GET['success'] ? $_GET['success']  : '';

if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $discount_id = $_POST['discount'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];


    if (!$error) {

        $data = [
            'discount_id' => $discount_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        var_dump($data);

        $result = insertData('discount_detail', $mysql, $data);

        if ($result) {
            $url = $admin_base_url . 'admin_dashboard.php?success=One row inserted.';
            header("Location: $url");
            exit;
        } else {
            var_dump("hello");
            $url = $admin_base_url . 'discount_detail_create.php?error=Error In Insertion';
            header("Location: $url");
            exit;
        }
    }
}
require 'header.php';

?>

<div class="main-wrapper ">
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
                    <h1 class="text-lg text-white mt-2">Discount Details Create</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="card-body pt-5">

            <a class="text-center" href="class_create.php">
                <h1 class="text-color">Create Discount</h1>
            </a>
            <form class="mt-5 mb-5 login-input" method="POST">
                <?php if ($success !== '') { ?>
                    <div class="alert alert-success">
                        <?= $success ?>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <select name="discount" class="form-control" id="">
                        <option value="">Apply Discount</option>
                        <?php while ($row = $select_discount->fetch_assoc()): ?>
                            <option value="<?= $row['discount_id'] ?>"><?= htmlspecialchars($row['name_of_package']) ?></option>
                        <?php endwhile; ?>
                    </select>
                    <br>
                </div>
                <div class="form-group">
                    <label for="start_time">Start Date</label>
                    <input type="date" class="form-control" placeholder="Start date" name="start_date" value="<?= $start_date ?>">
                </div>
                <div class="form-group">
                    <label for="end_time">End Date</label>
                    <input type="date" class="form-control" placeholder="End date" name="end_date" value="<?= $end_date ?> ">
                </div>
                <div class="form-group">
                    <label for="name" class="text-danger"><?= $time_error ?></label>
                </div>
                <input type="hidden" name="form_sub" value="1">
                <button class="btn btn-dark login-form__btn submit w-100">Submit</button>
            </form>
            <p class="mt-5 login-form__footer">Have account <a href="<?= $admin_base_url ?>login.php" class="text-primary">Sign in </a> now</p>
            </p>
        </div>
    </div>
</div>

<?php
require 'footer.php';
ob_end_flush();
?>