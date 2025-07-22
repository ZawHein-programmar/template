<?php
ob_start();
require 'databaserequire.php';
require 'common.php';
require "central_function.php";

$error = false;
$class_name = '';
$day_error = '';

$select_class = select_data('class', $mysql, '*', '', '');

$success = $_GET['success'] ? $_GET['success']  : '';

if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = $_POST['class'];
    $day_of_week = $_POST['day_of_week'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];


    if (!$error) {

        $data = [
            'class_id' => $class_id,
            'day_of_week' => $day_of_week,
            'start_time' => $start_time,
            'end_time' => $end_time
        ];

        $result = insertData('class_schedule', $mysql, $data);

        if ($result) {
            $url = $admin_base_url . 'class_schedule_create.php?success=One row inserted.';
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
                    <h1 class="text-lg text-white mt-2">Class Schedule Create</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="card-body pt-5">

            <a class="text-center" href="class_create.php">
                <h1 class="text-color">Create Class Schedule</h1>
            </a>
            <form class="mt-5 mb-5 login-input" method="POST">
                <?php if ($success !== '') { ?>
                    <div class="alert alert-success">
                        <?= $success ?>
                    </div>
                <?php } ?>
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
                    <select name="day_of_week" class="form-control" id="day_of_week">
                        <option value="">Day</option>
                        <option value="monday">Monday</option>
                        <option value="tuesday">Tuesday</option>
                        <option value="wednesday">Wednesday</option>
                        <option value="thursday">Thursday</option>
                        <option value="friday">Friday</option>
                        <option value="saturday">Saturday</option>
                    </select>
                    <label for="name" class="text-danger"><?= $day_error ?></label>
                </div>
                <div class="form-group">
                    <label for="start_time">Start Time</label>
                    <input type="time" class="form-control" placeholder="Start time" name="start_time" value="<?= $start_time ?>">
                </div>
                <div class="form-group">
                    <label for="end_time">End Time</label>
                    <input type="time" class="form-control" placeholder="End time" name="end_time" value="<?= $end_time ?> ">
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