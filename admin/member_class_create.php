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
$class_trainer_name = '';
$member_name = '';
$price = '';

$select_class_trainer = select_data('class_trainer', $conn, '*', '', '');
$select_member = select_data('member', $conn, '*', '', '');

$success = $_GET['success'] ? $_GET['success']  : '';


if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_trainer_id = $_POST['class'];
    $member_id = $_POST['member'];
    $enroll_date = $_POST['enroll_date'];

    //class validation
    if ($class_trainer_id == '' && strlen($class_trainer_id) == 0) {
        $error = true;
        $class_trainer_error = 'You must select.';
    } else {
        $class_trainer_error = 'Success';
    }

    //trainer validation
    if ($member_id == '' && strlen($member_id) == 0) {
        $error = true;
        $member_error = 'You must select member.';
    } else {
        $member_error = 'Success';
    }

    //enroll date validation
    if ($enroll_date == '') {
        $error = true;
        $enroll_date_error = 'You must input enroll date.';
    } else {
        $enroll_date_error = 'Success';
    }

    if (!$error) {
        // Start transaction

        try {
            mysqli_begin_transaction($conn);
            // Insert class information
            $data = [
                'member_id' => $member_id,
                'class_trainer_id' => $class_trainer_id,
                'enrolled_date' => $enroll_date
            ];

            $result = insertData('member_class', $conn, $data);

            if ($result) {
                mysqli_commit($conn);
                $url = '../admin/member_class_list.php?success=One row inserted.';
                header("Location: $url");
                exit;
            } else {
                mysqli_rollback($conn);
                $url = '../admin/member_class_create.php?error=Error In Insertion';
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
            <h3><i class="fas fa-calendar-alt me-2"></i>Create Class Member</h3>
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
                        <label for="member" class="form-label">
                            <i class="fas fa-chalkboard-teacher me-2"></i>Member
                        </label>
                        <select name="member" class="form-control" id="">
                            <option value="">Select Member</option>
                            <?php while ($member_row = $select_member->fetch_assoc()): ?>
                                <option value="<?= $member_row['member_id'] ?>"><?= htmlspecialchars($member_row['member_name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                        <?php if (isset($member_error) && $member_error) { ?>
                            <div class="text-danger small mt-1"><?= $member_error ?></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="class" class="form-label">
                            <i class="fas fa-chalkboard-teacher me-2"></i>Available Class with Trainer
                        </label>
                        <select name="class" class="form-control" id="class">
                            <option value="">Select Class</option>
                            <?php while ($row = $select_class_trainer->fetch_assoc()):
                                $select_class = "SELECT class_name FROM class WHERE class_id='" . $row['class_id'] . "' LIMIT 1";
                                $class_rsult = $conn->query($select_class);
                                $class_name = '';
                                if ($class_rsult && $class_rsult->num_rows > 0) {
                                    $class_row = $class_rsult->fetch_assoc();
                                    $class_name = $class_row['class_name'];
                                }

                                $select_trainer = "SELECT trainer_name FROM trainer WHERE trainer_id='" . $row['trainer_id'] . "' LIMIT 1";
                                $trainer_rsult = $conn->query($select_trainer);
                                $trainer_name = '';
                                if ($trainer_rsult && $trainer_rsult->num_rows > 0) {
                                    $trainer_row = $trainer_rsult->fetch_assoc();
                                    $trainer_name = $trainer_row['trainer_name'];
                                }
                            ?>
                                <option value="<?= $row['class_trainer_id'] ?>"><?= $class_name ?> by <?= $trainer_name ?></option>
                            <?php endwhile; ?>
                        </select>
                        <?php if (isset($class_trainer_error) && $class_error) { ?>
                            <div class="text-danger small mt-1"><?= $class_trainer_error ?></div>
                        <?php } ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="enroll_date" class="form-label">
                        <i class="fas fa-calendar-alt me-2"></i>Enroll Date
                    </label>
                    <input type="text" id="enroll_date" class="form-control flatpickr-input" name="enroll_date" value="<?= $enroll_date ?>" placeholder="Select enroll date" readonly>
                    <?php if (isset($date_error) && $date_error) { ?>
                        <div class="text-danger small mt-1"><?= $date_error ?></div>
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
    flatpickr("#enroll_date", {
        enableTime: false, // Disable time selection
        noCalendar: false, // Enable calendar
        dateFormat: "Y-m-d", // Set format to YYYY-MM-DD
    });
</script>