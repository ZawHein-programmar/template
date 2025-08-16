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


$success = $_GET['success'] ? $_GET['success']  : '';
if (isset($_GET['id']) && $_GET['id'] !== '') {
    $id = $_GET['id'];
    $selectData = select_data('member_class', $conn, "*", "WHERE `member_class_id`='$id'");


    if ($selectData->num_rows > 0) {
        $data = $selectData->fetch_assoc();
        $member_id = $data['member_id'];
        $class_trainer_id = $data['class_trainer_id'];
        $enroll_date = $data['enrolled_date'];
        $select_class_trainer_sql = $conn->query("
                                                SELECT ct.class_trainer_id, c.class_name, t.trainer_name
                                                FROM class_trainer ct
                                                JOIN class c ON ct.class_id = c.class_id
                                                JOIN trainer t ON ct.trainer_id = t.trainer_id
                                            ");
        // $da = $select_class_trainer->fetch_assoc();
        // var_dump($da);
        // exit;
        // $class_trainer_data = $select_class_trainer->fetch_assoc();
    } else {
        $url = "./discount_list.php?error=Id Not Found";
        header("Location: $url");
    }
    header("Location: $url");
}

$select_member = select_data('member', $conn, '*', '');
// $select_class_trainer = select_data('class_trainer', $conn, '*', '');
// var_dump($select_member);
// die;

if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_trainer_id = $_POST['class'];
    $member_id = $_POST['member'];
    $enroll_date = $_POST['enroll_date'];
    $edit_id = $_POST['hidden_id'];

    // var_dump($class_trainer_id, $member_id, $enroll_date);
    // die;

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
            $where = [
                'member_class_id' => $edit_id
            ];

            $result = updateData('member_class', $conn, $data, $where);
            // var_dump($result);
            // die;

            if ($result) {
                mysqli_commit($conn);
                $url = '../admin/member_class_list.php?success=Successfully updated.';
                header("Location: $url");
                exit;
            } else {
                mysqli_rollback($conn);
                $url = '../admin/member_class_create.php?error=Error In updating';
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

<div class="d-flex justify-content-end mt-3">
    <button onclick="window.history.back()" class="btn btn-glass">
        <i class="fa-solid fa-arrow-left me-2"></i>Back
    </button>
</div>
<div class="container mt-4 fade-in-up">
    <div class="card" style="background: var(--glass-bg); border-radius: 20px; box-shadow: var(--glass-shadow); border: 1.5px solid var(--glass-border); overflow: hidden;">
        <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.12);">
            <h3><i class="fas fa-calendar-alt me-2"></i>Update Class Member</h3>
        </div>
        <div class="card-body" style="color: var(--text-primary); font-weight: 600;">
            <form class="mt-3" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <input type="hidden" name="hidden_id" value="<?= $id ?>">
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
                                <option value="<?= $member_row['member_id'] ?>" <?= ($member_row['member_id'] == $member_id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($member_row['member_name']) ?>
                                </option>
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
                            <?php while ($class_trainer_row = $select_class_trainer_sql->fetch_assoc()): ?>
                                <option value="<?= $class_trainer_row['class_trainer_id'] ?>" <?= ($class_trainer_row['class_trainer_id'] == $class_trainer_id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($class_trainer_row['class_name']) ?> by <?= $class_trainer_row['trainer_name'] ?>
                                </option>
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