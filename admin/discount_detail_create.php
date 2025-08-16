<?php
$current_user = json_decode($_COOKIE["user"], true);
$user_role = $current_user['role'] ?? 0;
if ($user_role != "admin") {
    header("location:../home.php");
    exit;
}
require '../storage/db.php';
require '../storage/central_function.php';

$error = false;
$name_of_package = '';
$start_date = '';
$end_date = '';

$select_discount = select_data('discount', $conn, '*', '', '');

$success = $_GET['success'] ? $_GET['success']  : '';

if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $discount_id = $_POST['discount'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    // var_dump("helo");
    // die();

    if ($discount_id == '' && strlen($discount_id) < 1) {
        $error = true;
        header("Location: ../admin/discount_detail_create.php?error=Please select a discount");
        exit;
    }

    if (!$error) {

        $data = [
            'discount_id' => $discount_id,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        //inserting data to db structure

        $result = insertData('discount_detail', $conn, $data);

        if ($result) {
            // $url = $admin_base_url . 'add_member.php?success=Register Success';
            header("Location: ../admin/discount_detail_list.php?success=Successfully inserted");
            exit;
        } else {
            // $url = $admin_base_url . 'add_member.php?error=Error In Insertion';
            header("Location: ../admin/discount_detail_create.php?error=Error in insertion");
            exit;
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
            <h3><i class="fas fa-user-plus me-2" style="color: var(--text-primary); font-weight: 600;"></i>Discount Detail Create</h3>
        </div>
        <div class="card-body">
            <form class="mt-3" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-user me-2"></i>Discount Name
                        </label>
                        <select name="discount" class="form-control" id="">
                            <option value="">Select Discount</option>
                            <?php while ($row = $select_discount->fetch_assoc()): ?>
                                <option value="<?= $row['discount_id'] ?>"><?= htmlspecialchars($row['name_of_package']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">
                            <i class="fas fa-calendar-alt me-2"></i>Start Date
                        </label>
                        <input type="text" class="form-control flatpickr-input" id="start_date" name="start_date" value="<?= $start_date ?>" placeholder="Select start date" readonly>
                        <div class="form-text">Click to select start date</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="join_date" class="form-label">
                            <i class="fas fa-calendar-alt me-2"></i>End Date
                        </label>
                        <input type="text" class="form-control flatpickr-input" id="end_date" name="end_date" value="<?= $end_date ?>" placeholder="Select end date" readonly>
                        <div class="form-text">Click to select end date</div>
                    </div>
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

<!-- Flatpickr JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Initialize Flatpickr for DOB
    flatpickr("#start_date", {
        dateFormat: "Y-m-d",
        maxDate: "2030-12-31",
        minDate: "2020-01-01",
        allowInput: false,
        clickOpens: true,
        disableMobile: false,
        static: false,
        position: "above"
    });

    // Initialize Flatpickr for Join Date
    flatpickr("#end_date", {
        dateFormat: "Y-m-d",
        maxDate: "2030-12-31",
        minDate: "2020-01-01",
        allowInput: false,
        clickOpens: true,
        disableMobile: false,
        static: false,
        position: "above"
    });

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