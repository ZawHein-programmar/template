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

$success = $_GET['success'] ? $_GET['success']  : '';

if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_name = $_POST['name'];
    $description = $_POST['description'];

    // name validation
    if (strlen($class_name) == 0 && $class_name == '') {
        $error = true;
        $name_error = "Name is empty.";
    } else if (strlen($class_name) > 50) {
        $error = true;
        $name_error = "Your name is too long.";
    } else {
        $name_error = "Success name.";
    }

    //description validation
    if ($description == '' && strlen($description) == 0) {
        $error = true;
        $description_error = "You must fill class description.";
    } else {
        $description_error = "Complete.";
    }

    if (!$error) {

        //inserting class information
        $data = [
            'class_name' => $class_name,
            'description' => $description
        ];
        // var_dump($data);
        // exit;

        $result = insertData('class', $conn, $data);


        //inserting class image
        $class_id = mysqli_insert_id($conn);
        if ($result && $class_id && isset($_FILES['image'])) {
            $img = $_FILES['image'];
            $tmp = $img['tmp_name'];
            $ext = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
            $allowed = ['JPG', 'jpeg', 'png'];

            if (in_array($ext, $allowed)) {
                var_dump('halo');
                exit;
                $folder = "upload/";
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true); // Only on first run
                }
                $filename = date("Ymd_His") . "_" . uniqid() . "." . $ext;
                $path = $folder . $filename;

                if (move_uploaded_file($tmp, $path)) {
                    $data = ['image_path' => $path];
                    $insert = insertData('image', $conn, $data);
                    echo $insert ? "Uploaded!" : "DB insert failed.";
                } else {
                    echo "Upload move failed.";
                }
            } else {
                echo "Only JPG/PNG allowed.";
            }
        }
    }
}

?>

<?php
require_once('../adminLayout/header1.php'); ?>

<div class="container-fluid mt-5" style="width: 50%; margin: 0px auto;">
    <h3>Class Create</h3>
    <form class="mt-5 mb-5 login-input" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <?php if ($success !== '') { ?>
            <div class="alert alert-success">
                <?= $success ?>
            </div>
        <?php } ?>
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Name">
            <label for="name" class="text-danger"><?= $name_error ?></label>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="description" placeholder="Description">
            <label for="description" class="text-danger"><?= $description_error ?></label>
        </div>
        <!-- <div class="form-group">
            <input type="text" class="form-control" name="duration" placeholder="Duration">
            <label for="duration" class="text-danger"><?= $duration_error ?></label>
        </div> -->
        <div class="form-group">
            <input type="file" name="image[]" multiple class="form-control" id="product_img">
            <span class="error_msg text-danger"></span>
        </div>
        <br>
        <input type="hidden" name="form_sub" value="1">
        <button class="btn btn-dark login-form__btn submit w-100">Submit</button>
    </form>
</div>

<?php include_once('../adminLayout/footer.php'); ?>