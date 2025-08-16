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
$member_id = '';
$price = '';

$success = $_GET['success'] ? $_GET['success']  : '';

$select_class_trainer = select_data('class_trainer', $conn, '*', '', '');
$select_member = select_data('member', $conn, '*', '', '');

$paymentSql = "SELECT * FROM  member_class mc
                JOIN class_trainer ct ON mc.class_trainer_id = ct.class_trainer_id
                JOIN trainer t ON ct.trainer_id = t.trainer_id
                JOIN class c ON ct.class_id = c.class_id
                JOIN member m ON mc.member_id = m.member_id
                ORDER BY mc.enrolled_date DESC";
$paymentResult = $conn->query($paymentSql);

$discountSql = "SELECT * FROM discount_detail dd
                JOIN discount d ON dd.discount_id = d.discount_id";
$discountResult = $conn->query($discountSql);

if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_trainer_id = $_POST['class'];
    $member_class_id = $_POST['member_class'];
    $member_id = '';

    if ($member_class_id) {
        $sql = "SELECT member_id FROM member_class WHERE member_class_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $member_class_id);
        $stmt->execute();
        $stmt->bind_result($member_id);
        $stmt->fetch();
        $stmt->close();
    }

    $amount = $_POST['amount'];
    $payment_date = $_POST['date'] ?? '';
    $method = '';
    $discount_detail_id = $_POST['discount'] ?? '';
    $paymemt_date = date('Y-m-d', strtotime($payment_date));


    if (!$error) {
        // Start transaction

        try {
            mysqli_begin_transaction($conn);
            // Insert class information
            $data = [
                'member_class_id' => $member_class_id,
                'member_id' => $member_id,
                'amount' => $amount,
                'discount_detail_id' => $discount_detail_id,
                'method' => $method,
                'payment_date' => $payment_date
            ];
            // var_dump($data);
            // exit;

            $result = insertData('payment', $conn, $data);

            if ($result) {
                mysqli_commit($conn);
                $url = '../admin/payment_list.php?success=One row inserted.';
                header("Location: $url");
                exit;
            } else {
                mysqli_rollback($conn);
                $url = '../admin/payment.php?error=Error In Insertion';
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
            <h3><i class="fas fa-calendar-alt me-2"></i>Create Payment</h3>
        </div>
        <div class="card-body">
            <form class="mt-3" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <?php if ($success !== '') { ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2" style="color: var(--text-primary); font-weight: 600;"></i><?= $success ?>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="member" class="form-label">
                            <i class="fas fa-chalkboard-teacher me-2"></i>Member
                        </label>
                        <select name="member_class" class="form-control" id="member-select">
                            <option value="">Select Member</option>
                            <?php while ($member_row = $paymentResult->fetch_assoc()): ?>
                                <option
                                    data-member-id="<?= $member_row['member_id'] ?>"
                                    data-price="<?= $member_row['price'] ?>"
                                    value="<?= $member_row['member_class_id'] ?>">
                                    <?= htmlspecialchars($member_row['member_name']) . ", " . $member_row['class_name']  . " (" . $member_row['trainer_name']  . " )"  ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <?php if (isset($member_error) && $member_error) { ?>
                            <div class="text-danger small mt-1"><?= $member_error ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="date" class="form-label">
                            <i class="fas fa-clock me-2"></i>Date
                        </label>
                        <input type="text" class="form-control flatpickr-input" id="date" name="date" value="<?= $paymemt_date ?>" placeholder="Select date" readonly>
                        <div class="form-text">Click to select date of birth</div>
                    </div>
                    <div class="col-md-6 mb-3" id="discount-container" style="display: none;">
                        <label for="discount" class="form-label">
                            <i class="fas fa-chalkboard-teacher me-2"></i>Discount
                        </label>
                        <select name="discount" class="form-control" id="discount-select">
                            <option value="">Select Discount</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="member" class="form-label">
                            <i class="fas fa-dollar me-2"></i>Amount
                        </label>
                        <input type="number" name="amount" id="amount" class="form-control">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    flatpickr("#date", {
        enableTime: false,
        noCalendar: false,
        dateFormat: "Y-m-d",
    });

    $(document).ready(() => {
        let discountContainer = $("#discount-container");
        let discountSelect = $("#discount-select");
        let amountInput = $("#amount");

        $("#member-select").on("change", () => {
            const selectedOption = $("#member-select option:selected");
            let price = selectedOption.data("price") || 0;
            amountInput.val(price);

            if (selectedOption.val() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select a member first.',
                });
                $("#date").val("");
                discountContainer.hide();
                discountSelect.empty().append("<option value=''>Select Discount</option>");
            } else {
                discountSelect.empty().append("<option value=''>Select Discount</option>");
                discountContainer.hide();
            }
        });

        $("#date").on("change", function() {
            if ($("#member-select").val() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select a member first.',
                });
                $(this).val("");
                discountContainer.hide();
                return;
            }



            let dateValue = $(this).val();

            $.ajax({
                url: './check_date.php',
                type: 'POST',
                contentType: 'application/json',
                dataType: 'json',
                data: JSON.stringify({
                    date: dateValue
                }),
                success: function(response) {
                    if (response.status == "success" && response.date.length > 0) {
                        discountSelect.empty().append("<option value=''>Select Discount</option>");
                        response.date.forEach((discount) => {
                            discountSelect.append($("<option>", {
                                value: discount.discount_detail_id,
                                text: discount.name_of_package + ` (${discount.percentage}% off)`,
                                "data-percentage": discount.percentage
                            }));
                        });
                        discountContainer.show();
                    } else {
                        discountContainer.hide();
                        discountSelect.empty().append("<option value=''>No discounts available</option>");
                        amountInput.val($("#member-select option:selected").data("price") || 0);
                    }
                },
                error: function() {
                    alert('An error occurred while checking the date.');
                }
            });
        });

        // Correctly apply discount on selection
        discountSelect.on("change", function() {
            let percent = parseFloat($("#discount-select option:selected").data("percentage")) || 0;
            let originalPrice = parseFloat($("#member-select option:selected").data("price")) || 0;

            if (percent > 0) {
                let discounted = originalPrice - (originalPrice * (percent / 100));
                amountInput.val(Math.ceil(discounted.toFixed(2)));
            } else {
                amountInput.val(originalPrice);
            }
        });
    });
</script>