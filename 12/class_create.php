<?php
ob_start();
require 'databaserequire.php';
require 'common.php';
require "central_function.php";
$error = false;
$class_name = '';
$description = '';

$success = $_GET['success'] ? $_GET['success']  : '';

if (isset($_POST['form_sub']) && $_POST['form_sub'] == 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_name = $_POST['name'];
    $description = $_POST['description'];

    $files          = $_FILES['image'];
    $fileName = $files['name'];
    $allowExtension = ['PNG', 'JPG', 'JPEG'];
    $folder = 'upload/';

    //name validation
    if ($class_name == '' && strlen($class_name) == 0) {
        $error = true;
        $name_error = "You need to type your name.";
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

        $data = [
            'class_name' => $class_name,
            'description' => $description
        ];

        $result = insertData('class', $mysql, $data);

        $class_id = $mysql->insert_id;
        foreach ($fileName as $key => $val) {
            $extension = explode('.', $val);
            $extension = end($extension);
            $tmpPath = $files['tmp_name'][$key];

            if (!in_array($extension, $allowExtension)) {
                $error = true;
                $file_error = "File only allowed: png, jpg, jpeg";
            } else {
                if (!file_exists($folder)) {
                    mkdir($folder, 0755, true); // Create folder with permission
                }
                var_dump("helo");
                die();
                $currentName = date("Ymd_His") . "_" . $val;
                $fullPath = $folder . "/" . $currentName; // Full path to save image

                // Save data to DB
                $img_data = [
                    'type'      => "class",
                    'target_id' => $class_id,
                    'img'       => $currentName
                ];
                $result = insertData('image', $mysql, $img_data);
            }
        }

        if ($result && $saveImg) {
            $url = $admin_base_url . 'class_create.php?success=Class Create Success';
            header("Location: $url");
            exit;
        } else {
            var_dump("hello");
            $url = $admin_base_url . 'class_create.php?error=Error In Insertion';
            header("Location: $url");
            exit;
        }
    }
}
echo $file_error;
require 'header.php';

?>

<div class="main-wrapper ">
    <section class="page-title bg-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="index.php"
                                class="text-sm letter-spacing text-white text-uppercase font-weight-bold">Home</a>
                        </li>
                        <li class="list-inline-item"><span class="text-white">|</span></li>
                        <li class="list-inline-item"><a href="#"
                                class="text-color text-uppercase text-sm letter-spacing">Team</a></li>
                    </ul>
                    <h1 class="text-lg text-white mt-2">Class Create</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="card-body pt-5">

            <a class="text-center" href="class_create.php">
                <h1 class="text-color">Create Class</h1>
            </a>

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
                <div class="form-group">
                    <input type="file" name="image[]" multiple class="form-control" id="product_img">
                    <span class="error_msg text-danger"></span>
                </div>
                <input type="hidden" name="form_sub" value="1">
                <button class="btn btn-dark login-form__btn submit w-100">Submit</button>
            </form>
            <p class="mt-5 login-form__footer">Have account <a href="<?= $admin_base_url ?>login.php" class="text-primary">Sign in </a> now</p>
            </p>
        </div>
    </div>
</div>

<?php
require 'footer.php';
ob_end_flush();
?>