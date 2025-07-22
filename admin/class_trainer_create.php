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

$error = false;
$class_name = '';
$trainer_name = '';
$price = '';

$select_class = select_data('class', $conn, '*', '', '');
$select_trainer = select_data('trainer', $conn, '*', '', '');

$success = $_GET['success'] ? $_GET['success']  : '';


if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = $_POST['class'];
    $trainer_id = $_POST['trainer'];
    $price = $_POST['price'];

    //class validation
    if ($class_id == '' && strlen($class_id) == 0) {
        $error = true;
        $class_error = 'You should select class name.';
    } else {
        $class_error = '';
    }

    //trainer validation
    if ($trainer_id == '' && strlen($trainer_id) == 0) {
        $error = true;
        $trainer_error = 'You should select trainer name.';
    } else {
        $trainer_error = 'Success';
    }

    //price validation
    if ($price == '') {
        $error = true;
        $price_error = 'You must input price.';
    } else {
        $price_error = '';
    }

    if (!$error) {
        // Start transaction

        try {
            mysqli_begin_transaction($conn);
            // Insert class information
            $data = [
                'class_id' => $class_id,
                'trainer_id' => $trainer_id,
                'price' => $price
            ];
            $result = insertData('class_trainer', $conn, $data);

            if ($result) {
                mysqli_commit($conn);
                $url = '../admin/class_trainer_list.php?success=One row inserted.';
                header("Location: $url");
                exit;
            } else {
                mysqli_rollback($conn);
                $url = '../admin/class_trainer_create.php?error=Error In Insertion';
                header("Location: $url");
                exit;
            }
        } catch (Exception $e) {
            mysqli_rollback($conn);
            $error = true;
            $day_error = "Error: " . $e->getMessage();
        }
    }
}
?>

<?php
require_once('../adminLayout/header1.php'); ?>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container mt-4 fade-in-up">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-calendar-alt me-2"></i>Create Class Trainer</h3>
        </div>
        <div class="card-body">
            <form class="mt-3" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <?php if ($success !== '') { ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i><?= $success ?>
                    </div>
                <?php } ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="class" class="form-label">
                            <i class="fas fa-chalkboard-teacher me-2"></i>Class
                        </label>
                        <select name="class" class="form-control" id="class">
                            <option value="">Select Class</option>
                            <?php while ($row = $select_class->fetch_assoc()): ?>
                                <option value="<?= $row['class_id'] ?>"><?= htmlspecialchars($row['class_name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                        <?php if (isset($class_error) && $class_error) { ?>
                            <div class="text-danger small mt-1"><?= $class_error ?></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="class" class="form-label">
                            <i class="fas fa-chalkboard-teacher me-2"></i>Trainer
                        </label>
                        <select name="trainer" class="form-control" id="class">
                            <option value="">Select Trainer</option>
                            <?php while ($trainer_row = $select_trainer->fetch_assoc()): ?>
                                <option value="<?= $trainer_row['trainer_id'] ?>"><?= htmlspecialchars($trainer_row['trainer_name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                        <?php if (isset($trainer_error) && $trainer_error) { ?>
                            <div class="text-danger small mt-1"><?= $trainer_error ?></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">
                        <i class="fas fa-dollar me-2"></i>Price
                    </label>
                    <input type="number" class="form-control" id="price" name="price" value="<?= $price ?>" placeholder="Enter price" step="0.1" min="0">
                    <?php if (isset($price_error) && $price_error) { ?>
                        <div class="text-danger small mt-1"><?= $price_error ?></div>
                    <?php } ?>
                </div>
                <input type="hidden" name="form_sub" value="1">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('../adminLayout/footer.php'); ?>
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#start_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });
    flatpickr("#end_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });
</script>