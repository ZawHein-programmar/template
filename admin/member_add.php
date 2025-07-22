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
$name = '';
$email = '';
$phone = '';
$dob = '';
$address = '';
$gender = '';
$join_date = '';
$original_weight = '';

if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $join_date = $_POST['join_date'];
    $original_weight = $_POST['original_weight'];

    //name validation
    if ($name == '' && strlen($name) == 0) {
        $error = true;
        $name_error = "You need to type your name.";
    } else if (strlen($name) > 50) {
        $error = true;
        $name_error = "Your name is too long.";
    } else {
        $name_error = "Success name.";
    }

    //email validation
    $email_format = "/^[\w\-\.]+@([\w\-]+\.)+[a-zA-Z]{2,7}$/";
    if ($email == '' && strlen($email) == 0) {
        $error = true;
        $email_error = "Your must fill your email.";
    } else if (!preg_match($email_format, $email)) {
        $error = true;
        $email_error = "Your email format is wrong.";
    } else if (strlen($email) > 100) {
        $error = true;
        $email_error = "Your email is too long.";
    } else {
        $email_error = "Success email.";
    }

    //phone number validation
    $number_format = '/^\+?[0-9\s\-]{10,15}$/';
    if ($phone == '' && strlen($phone) == 0) {
        $error = true;
        $phone_error = "You need to type your phone number.";
    } else if (!preg_match($number_format, $phone)) {
        $error = true;
        $phone_error = "Wrong phone number fomrat.";
    } else {
        $phone_error = "Correct.";
    }

    //address validation
    if ($address == '' && strlen($address) == 0) {
        $error = true;
        $address_error = "You must fill your address.";
    } else {
        $address_error = "Complete.";
    }

    // Gender Validation
    if (strlen($gender) === 0) {
        $error = true;
        $gender_error = "Gender is require.";
    }

    //orginal weight validation
    if (strlen($original_weight) == 0) {
        $error = true;
        $original_weight_error = "Your must fill original weight.";
    }

    if (!$error) {

        $data = [
            'member_name' => $name,
            'email' => $email,
            'phone' => $phone,
            'DOB' => $dob,
            'gender' => $gender,
            'address' => $address,
            'join_date' => $join_date,
            'original_weight' => $original_weight
        ];

        //inserting data to db structure

        $result = insertData('member', $conn, $data);
        // var_dump($result);
        // die();

        if ($result) {
            // $url = $admin_base_url . 'add_member.php?success=Register Success';
            header("Location: ../admin/member_list.php?success=Successfully inserted");
            exit;
        } else {
            // $url = $admin_base_url . 'add_member.php?error=Error In Insertion';
            header("Location: ../admin/member_add.php?error=Error in insertion");
            exit;
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
            <h3><i class="fas fa-user-plus me-2"></i>Add New Member</h3>
        </div>
        <div class="card-body">
            <form class="mt-3" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-user me-2"></i>Member Name
                        </label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $name ?>" placeholder="Enter member name">
                        <?php if (isset($name_error) && $name_error !== "Success name.") { ?>
                            <div class="text-danger small mt-1"><?= $name_error ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email Address
                        </label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>" placeholder="Enter email address">
                        <?php if (isset($email_error) && $email_error !== "Success email.") { ?>
                            <div class="text-danger small mt-1"><?= $email_error ?></div>
                        <?php } ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">
                            <i class="fas fa-phone me-2"></i>Phone Number
                        </label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $phone ?>" placeholder="Enter phone number">
                        <?php if (isset($phone_error) && $phone_error !== "Correct.") { ?>
                            <div class="text-danger small mt-1"><?= $phone_error ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="dob" class="form-label">
                            <i class="fas fa-birthday-cake me-2"></i>Date of Birth
                        </label>
                        <input type="text" class="form-control flatpickr-input" id="dob" name="dob" value="<?= $dob ?>" placeholder="Select date of birth" readonly>
                        <div class="form-text">Click to select date of birth</div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">
                        <i class="fas fa-map-marker-alt me-2"></i>Address
                    </label>
                    <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter member address"><?= $address ?></textarea>
                    <?php if (isset($address_error) && $address_error !== "Complete.") { ?>
                        <div class="text-danger small mt-1"><?= $address_error ?></div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-venus-mars me-2"></i>Gender
                        </label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="male" id="male" name="gender" <?= $gender == 'male' ? 'checked' : '' ?> />
                                <label class="form-check-label" for="male">
                                    <i class="fas fa-mars me-1"></i>Male
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="female" id="female" name="gender" <?= $gender == 'female' ? 'checked' : '' ?> />
                                <label class="form-check-label" for="female">
                                    <i class="fas fa-venus me-1"></i>Female
                                </label>
                            </div>
                        </div>
                        <?php if (isset($gender_error) && $gender_error) { ?>
                            <div class="text-danger small mt-1"><?= $gender_error ?></div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="join_date" class="form-label">
                            <i class="fas fa-calendar-alt me-2"></i>Join Date
                        </label>
                        <input type="text" class="form-control flatpickr-input" id="join_date" name="join_date" value="<?= $join_date ?>" placeholder="Select join date" readonly>
                        <div class="form-text">Click to select join date</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="original_weight" class="form-label">
                        <i class="fas fa-weight me-2"></i>Original Weight (kg)
                    </label>
                    <input type="number" class="form-control" id="original_weight" name="original_weight" value="<?= $original_weight ?>" placeholder="Enter original weight" step="0.1" min="0">
                    <?php if (isset($original_weight_error) && $original_weight_error) { ?>
                        <div class="text-danger small mt-1"><?= $original_weight_error ?></div>
                    <?php } ?>
                </div>

                <input type="hidden" name="form_sub" value="1">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Register Member
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
    flatpickr("#dob", {
        dateFormat: "Y-m-d",
        maxDate: "today",
        minDate: "1900-01-01",
        allowInput: false,
        clickOpens: true,
        disableMobile: false,
        static: true
    });

    // Initialize Flatpickr for Join Date
    flatpickr("#join_date", {
        dateFormat: "Y-m-d",
        maxDate: "today",
        minDate: "2020-01-01",
        allowInput: false,
        clickOpens: true,
        disableMobile: false,
        static: true
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