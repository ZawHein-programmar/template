<?php
ob_start();
require 'databaserequire.php';
require 'common.php';
require "central_function.php";

$error = false;
$class_name = '';
$price = '';

$select_class = select_data('class', $mysql, '*', '', '');
$select_trainer = select_data('trainer', $mysql, '*', '', '');

$success = $_GET['success'] ? $_GET['success']  : '';

if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $trainer_id = $_POST['trainer'];
    $class_id = $_POST['class'];
    $price = $_POST['price'];

    if (!$error) {

        $data = [
            'trainer_id' => $trainer_id,
            'class_id' => $class_id,
            'price' => $price
        ];

        $result = insertData('class_trainer', $mysql, $data);

        if ($result) {
            $url = $admin_base_url . 'class_trainer.php?success=Successfully inserted.';
            header("Location: $url");
            exit;
        } else {
            var_dump("hello");
            $url = $admin_base_url . 'class_schedule_create.php?error=Error In Insertion';
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
                    <h1 class="text-lg text-white mt-2">Class Details Create</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="card-body pt-5">

            <a class="text-center" href="class_create.php">
                <h1 class="text-color">Create Class Details</h1>
            </a>
            <form class="mt-5 mb-5 login-input" method="POST">
                <?php if ($success !== '') { ?>
                    <div class="alert alert-success">
                        <?= $success ?>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <select name="trainer" class="form-control" id="">
                        <option value="">Trainer</option>
                        <?php while ($row = $select_trainer->fetch_assoc()): ?>
                            <option value="<?= $row['trainer_id'] ?>"><?= htmlspecialchars($row['trainer_name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                    <br>
                </div>
                <div class="form-group">
                    <select name="class" class="form-control" id="">
                        <option value="">Class</option>
                        <?php while ($row = $select_class->fetch_assoc()): ?>
                            <option value="<?= $row['class_id'] ?>"><?= htmlspecialchars($row['class_name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                    <br>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" name="price" placeholder="Price">
                    <label for="name" class="text-danger"><?= $price_error ?></label>
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