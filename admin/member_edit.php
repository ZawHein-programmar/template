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

if (isset($_GET['id']) && $_GET['id'] !== '') {
    $id = $_GET['id'];
    $selectData = select_data('member', $conn, "*", "WHERE `member_id`='$id'");

    if ($selectData->num_rows > 0) {
        $data = $selectData->fetch_assoc();
        $name = $data['name'];
    } else {
        $url = "./member_list.php?error=Id Not Found";
        header("Location: $url");
    }
}


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
            'address' => $address,
            'gender' => $gender,
            'original_weight' => $original_weight
        ];
        $where = [
            'member_id' => $id
        ];

        // updating members details
        $result = updateData('member', $conn, $data, $where);

        if ($result) {
            $url = './member_list.php?success=Update Success';
            header("Location: $url");
            exit;
        } else {
            $error = true;
            $error_message = "Member Update Fail.";
        }
    }
}

?>

<?php
require_once('../adminLayout/header1.php'); ?>

<div class="container-fluid mt-5" style="width: 50%; margin: 0px auto;">
    <h3>Edit Member</h3>
    <form class="mt-5 mb-5 login-input" action="<?= './member_edit.php?id=' . $id ?>" method="POST">
        <div class="form-group">
            <input type="text" class="form-control" name="name" value="<?= $data['member_name'] ?>" placeholder="Name">
            <label for="name" class="text-danger"><?= $name_error ?></label>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" value="<?= $data['email'] ?>" placeholder="Email">
            <label for="name" class="text-danger"><?= $email_error ?></label>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="phone" value="<?= $data['phone'] ?>" placeholder="Phone">
            <label for="name" class="text-danger"><?= $phone_error ?></label>
        </div>
        <div class="form-group">
            <input type="date" class="form-control" name="dob" value="<?= $data['DOB'] ?>" placeholder="Date of Birth">
            <label for="name" class="text-danger"></label>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="address" value="<?= $data['address'] ?>" placeholder="Address">
            <label for="name" class="text-danger"><?= $address_error ?></label>
        </div>
        <div class="form-group d-flex">
            <div class="form-check mr-5">
                <input class="form-check-input" type="radio" value="male" id="male" name="gender" <?= $data['gender'] == 'male' ? 'checked' : '' ?> />
                <label class="form-check-label" for="male">
                    Male
                </label>
            </div>
            <div class="form-check mr-5">
                <input class="form-check-input" type="radio" value="female" id="female" name="gender" <?= $data['gender'] == 'female' ? 'checked' : '' ?> />
                <label class="form-check-label" for="female">
                    Female
                </label>
            </div>
            <?php if ($error && $gender_error) { ?>
                <span class="text-danger"><?= $gender_error ?></span>
            <?php } ?>
        </div>
        <div class="form-group">
            <input type="date" id="dob" class="form-control" name="join_date" value="<?= $data['join_date'] ?>" placeholder="Join Date">
            <label for="name" class="text-danger"></label>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="original_weight" value="<?= $data['original_weight'] ?>" placeholder="Oiginal Weight">
            <label for="name" class="text-danger"><?= $original_weight_error ?></label>
        </div>
        <input type="hidden" name="form_sub" value="1">
        <button class="btn btn-dark login-form__btn submit w-100">Submit</button>
    </form>
</div>

<?php include_once('../adminLayout/footer.php'); ?>