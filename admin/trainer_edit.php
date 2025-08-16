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
$specialty = '';
$bio = '';
$gender = '';
$join_date = '';

if (isset($_GET['id']) && $_GET['id'] !== '') {
    $id = $_GET['id'];
    $selectData = select_data('trainer', $conn, "*", "WHERE `trainer_id`='$id'");
    // var_dump($selectData);
    // exit;

    if ($selectData->num_rows > 0) {
        $data = $selectData->fetch_assoc();
        $name = $data['name'];
    } else {
        $url = "./trainer_list.php?error=Id Not Found";
        header("Location: $url");
    }
    // } else {
    //     $url = "./member_list.php?error=Id now Found";
    //     header("Location: $url");
}


if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $specialty = $_POST['specialty'];
    $gender = $_POST['gender'];
    $bio = $_POST['bio'];
    $join_date = $_POST['join_date'];

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
        $phone_error = "You need to type trainer phone number.";
    } else if (!preg_match($number_format, $phone)) {
        $error = true;
        $phone_error = "Wrong phone number fomrat.";
    } else {
        $phone_error = "Correct.";
    }

    //specialty validation
    if ($specialty == '' && strlen($specialty) == 0) {
        $error = true;
        $specialty_error = "You must fill trainer specialty.";
    } else {
        $specialty_error = "Complete.";
    }

    // Gender Validation
    if (strlen($gender) === 0) {
        $error = true;
        $gender_error = "Gender is require.";
    }

    //bio validation
    if ($bio == '' && strlen($bio) == 0) {
        $error = true;
        $bio_error = "You must fill trainer bio.";
    } else {
        $bio_error = "Complete.";
    }


    if (!$error) {
        $data = [
            'trainer_name' => $name,
            'email' => $email,
            'phone' => $phone,
            'specialty' => $specialty,
            'gender' => $gender,
            'bio' => $bio,
            'join_date' => $join_date
        ];
        $where = [
            'trainer_id' => $id
        ];

        // updating members details
        $result = updateData('trainer', $conn, $data, $where);

        if ($result) {
            $url = './trainer_list.php?success=Update Success';
            header("Location: $url");
            exit;
        } else {
            $error = true;
            $error_message = "Trainer Update Fail.";
        }
    }
}

?>

<?php
require_once('../adminLayout/header1.php'); ?>

<div class="d-flex justify-content-end mt-3">
    <button onclick="window.history.back()" class="btn btn-glass">
        <i class="fa-solid fa-arrow-left me-2"></i>Back
    </button>
</div>
<div class="container-fluid mt-5" style="width: 50%; margin: 0px auto;">
    <h3>Edit Member</h3>
    <form class="mt-5 mb-5 login-input" action="<?= './trainer_edit.php?id=' . $id ?>" method="POST">
        <div class="form-group">
            <input type="text" class="form-control" name="name" value="<?= $data['trainer_name'] ?>" placeholder="Trainer Name">
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
            <input type="text" class="form-control" name="specialty" value="<?= $data['specialty'] ?>" placeholder="Specialty">
            <label for="name" class="text-danger"><?= $specialty_error ?></label>
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
        <br>
        <div class="form-group">
            <input type="text" class="form-control" name="bio" value="<?= $data['bio'] ?>" placeholder="Bio">
            <label for="name" class="text-danger"><?= $bio_error ?></label>
        </div>
        <div class="form-group">
            <input type="date" id="dob" class="form-control" name="join_date" value="<?= $data['join_date'] ?>" placeholder="Join Date">
            <label for="name" class="text-danger"></label>
        </div>
        <input type="hidden" name="form_sub" value="1">
        <button class="btn btn-dark login-form__btn submit w-100">Submit</button>
    </form>
</div>

<?php include_once('../adminLayout/footer.php'); ?>