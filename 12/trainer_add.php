<?php
ob_start();
require 'databaserequire.php';
require 'common.php';
require "central_function.php";

$error = false;
$name = '';
$email = '';
$phone = '';
$specialty = '';
$dob = '';
$bio = '';
$gender = '';
$join_date = '';


if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $specialty = $_POST['specialty'];
    $dob = $_POST['dob'];
    $bio = $_POST['bio'];
    $gender = $_POST['gender'];
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
        $phone_error = "You need to type your phone number.";
    } else if (!preg_match($number_format, $phone)) {
        $error = true;
        $phone_error = "Wrong phone number fomrat.";
    } else {
        $phone_error = "Correct.";
    }

    //trainer bio validation
    if ($bio == '' && strlen($bio) == 0) {
        $error = true;
        $bio_error = "You must fill trainer bio.";
    } else {
        $bio_error = "Complete.";
    }

    // Gender Validation
    if (strlen($gender) === 0) {
        $error = true;
        $gender_error = "Gender is require.";
    }


    if (!$error) {

        $sql = "INSERT INTO `trainer` 
                (`trainer_name`,`email`,`phone`,`specialty`,`gender`,`bio`,`join_date`)
                VALUES ('$name','$email','$phone','$specialty','$gender','$address','$join_date')";

        $result = $mysql->query($sql);

        if ($result) {
            $url = $admin_base_url . 'trainer_add.php?success=Register Success';
            header("Location: $url");
            exit;
        } else {
            echo "Insert failed: " . $mysql->error;
            exit;
        }
    }
}



require 'header.php';
require 'under_header.php';


?>

<div class="card-body pt-5">

    <a class="text-center" href="trainer_add.php">
        <h1 class="text-color">New Trainer Add</h1>
    </a>

    <form class="mt-5 mb-5 login-input" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="form-group">
            <input type="text" class="form-control" name="name" value="<?= $name ?>" placeholder="Trainer Name">
            <label for="name" class="text-danger"><?= $name_error ?></label>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" value="<?= $email ?>" placeholder="Email">
            <label for="name" class="text-danger"><?= $email_error ?></label>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="phone" value="<?= $phone ?>" placeholder="Phone">
            <label for="name" class="text-danger"><?= $phone_error ?></label>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="specialty" value="<?= $specialty ?>" placeholder="Specialty">
            <label for="name" class="text-danger"><?= $specialty_error ?></label>
        </div>
        <div class="form-group">
            <input type="date" class="form-control" name="dob" value="<?= $dob ?>" placeholder="Date of Birth">
            <label for="name" class="text-danger"></label>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="bio" value="<?= $bio ?>" placeholder="Bio">
            <label for="name" class="text-danger"><?= $bio_error ?></label>
        </div>
        <div class="form-group d-flex">
            <div class="form-check mr-5">
                <input class="form-check-input" type="radio" value="male" id="male" name="gender" <?= $gender == 'male' ? 'checked' : '' ?> />
                <label class="form-check-label" for="male">
                    Male
                </label>
            </div>
            <div class="form-check mr-5">
                <input class="form-check-input" type="radio" value="female" id="female" name="gender" <?= $gender == 'female' ? 'checked' : '' ?> />
                <label class="form-check-label" for="female">
                    Female
                </label>
            </div>
            <?php if ($error && $gender_error) { ?>
                <span class="text-danger"><?= $gender_error ?></span>
            <?php } ?>
        </div>
        <div class="form-group">
            <input type="date" id="dob" class="form-control" name="join_date" value="<?= $join_date ?>" placeholder="Join Date">
            <label for="name" class="text-danger"></label>
        </div>
        <input type="hidden" name="form_sub" value="1">
        <button class="btn btn-dark login-form__btn submit w-100">Submit</button>
    </form>
</div>
</div>
</div>



<?php
require 'footer.php';
ob_end_flush();
?>