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
$description = '';
$duration = '';

$select_class = select_data('class', $conn, '*', '', '');

$success = $_GET['success'] ? $_GET['success']  : '';
var_dump($success);

if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = $_POST['class'];
    $day_of_week = $_POST['day_of_week'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    //class validation
    if ($class_id == '' && strlen($class_id) == 0) {
        $error = true;
        $class_error = 'You should select class name.';
    } else {
        $class_error = '';
    }

    //day validation
    if ($day_of_week == '') {
        $error = true;
        $day_error = 'You should select day.';
    } else {
        $day_error = '';
    }

    //time validation
    if ($start_time == '') {
        $error = true;
        $start_time_error = 'You should fill start time.';
    } else {
        $start_time_error = '';
    }

    //end time validation
    if ($end_time == '') {
        $error = true;
        $end_time_error = 'You should fill end time.';
    } else {
        $end_time_error = '';
    }

    if (!$error) {
        // Start transaction

        try {
            mysqli_begin_transaction($conn);
            // Insert class information
            $data = [
                'class_id' => $class_id,
                'day_of_week' => $day_of_week,
                'start_time' => $start_time,
                'end_time' => $end_time
            ];
            $result = insertData('class_schedule', $conn, $data);

            if ($result) {
                mysqli_commit($conn);
                $url = '../admin/class_schedule_create.php?success=One row inserted.';
                header("Location: $url");
                exit;
            } else {
                mysqli_rollback($conn);
                $url = '../admin/class_schedule_create.php?error=Error In Insertion';
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
            <h3><i class="fas fa-calendar-alt me-2"></i>Create Class Schedule</h3>
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
                            <i class="fas fa-chalkboard-teacher me-2"></i>Class Name
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
                    <div class="col-md-6 mb-3">
                        <label for="day_of_week" class="form-label">
                            <i class="fas fa-calendar-day me-2"></i>Day of Week
                        </label>
                        <select name="day_of_week" class="form-control" id="day_of_week">
                            <option value="">Select Day</option>
                            <option value="monday">Monday</option>
                            <option value="tuesday">Tuesday</option>
                            <option value="wednesday">Wednesday</option>
                            <option value="thursday">Thursday</option>
                            <option value="friday">Friday</option>
                            <option value="saturday">Saturday</option>
                        </select>
                        <?php if (isset($day_error) && $day_error) { ?>
                            <div class="text-danger small mt-1"><?= $day_error ?></div>
                        <?php } ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_time" class="form-label">
                            <i class="fas fa-clock me-2"></i>Start Time
                        </label>
                        <input type="text" id="start_time" name="start_time" class="form-control flatpickr-input" placeholder="Select start time" required readonly>
                        <?php if (isset($start_time_error) && $start_time_error) { ?>
                            <div class="text-danger small mt-1"><?= $start_time_error ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_time" class="form-label">
                            <i class="fas fa-clock me-2"></i>End Time
                        </label>
                        <input type="text" id="end_time" name="end_time" class="form-control flatpickr-input" placeholder="Select end time" required readonly>
                        <?php if (isset($end_time_error) && $end_time_error) { ?>
                            <div class="text-danger small mt-1"><?= $end_time_error ?></div>
                        <?php } ?>
                    </div>
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