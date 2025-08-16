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
try {
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
            // Start transaction
            mysqli_begin_transaction($conn);

            try {
                // Insert class information
                $data = [
                    'class_name' => $class_name,
                    'description' => $description
                ];
                $result = insertData('class', $conn, $data);

                $class_id = mysqli_insert_id($conn);

                // Insert class image(s)
                $image_success = true;
                $uploaded_files = []; // Track uploaded files

                if ($result && $class_id && isset($_FILES['image'])) {
                    $images = $_FILES['image'];
                    $allowed = ['JPG', 'jpeg', 'png', 'jpg'];

                    // Handle multiple files
                    for ($i = 0; $i < count($images['name']); $i++) {
                        $tmp = $images['tmp_name'][$i];
                        $ext = strtolower(pathinfo($images['name'][$i], PATHINFO_EXTENSION));

                        if (in_array($ext, $allowed)) {
                            $folder = "upload/";
                            if (!file_exists($folder)) {
                                mkdir($folder, 0777, true);
                            }
                            $filename = date("Ymd_His") . "_" . uniqid() . "." . $ext;
                            $path = $folder . $filename;

                            if (move_uploaded_file($tmp, $path)) {
                                $uploaded_files[] = $path; // Track file
                                $img_data = [
                                    'img' => $path,
                                    'type' => 'class',
                                    'target_id' => $class_id
                                ];
                                $insert = insertData('image', $conn, $img_data);
                                if (!$insert) {
                                    $image_success = false;
                                    $name_error = "Image insert failed: " . mysqli_error($conn);
                                }
                            } else {
                                $image_success = false;
                                $name_error = "Failed to move uploaded file.";
                            }
                        } else {
                            $image_success = false;
                            $name_error = "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
                        }
                    }
                }

                // Commit or rollback
                if ($result && $image_success) {
                    mysqli_commit($conn);
                    $success = "Class created successfully!";
                    header("Location: class_list.php?success=" . urlencode($success));
                    exit;
                } else {
                    // Delete uploaded files if transaction fails
                    foreach ($uploaded_files as $file) {
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                    mysqli_rollback($conn);
                    $error = true;
                    $name_error = "Database insert failed. Transaction rolled back. MySQL error: " . mysqli_error($conn);
                    header("Location: class_create.php?error=" . urlencode($name_error));
                    exit;
                }
            } catch (Exception $e) {
                mysqli_rollback($conn);
                $error = true;
                $description_error = "Error: " . $e->getMessage();
            }
        }
    }
} catch (Exception $e) {
    var_dump($e->getMessage());
    exit;
}
?>

<?php
require_once('../adminLayout/header1.php'); ?>


<div class="d-flex justify-content-end mt-3">
    <button onclick="window.history.back()" class="btn btn-glass">
        <i class="fa-solid fa-arrow-left me-2"></i>Back
    </button>
</div>
<div class="container mt-4 fade-in-up">
    <div class="card" style="background: var(--glass-bg); border-radius: 20px; box-shadow: var(--glass-shadow); border: 1.5px solid var(--glass-border); overflow: hidden;">
        <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.12);">
            <h3><i class="fas fa-chalkboard-teacher me-2" style="color: var(--text-primary); font-weight: 600;"></i>Create New Class</h3>
        </div>
        <div class="card-body">
            <form class="mt-3" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                <?php if ($success !== '') { ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i><?= $success ?>
                    </div>
                <?php } ?>

                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="fas fa-graduation-cap me-2"></i>Class Name
                    </label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $class_name ?>" placeholder="Enter class name">
                    <?php if (isset($name_error) && $name_error !== "Success name.") { ?>
                        <div class="text-danger small mt-1"><?= $name_error ?></div>
                    <?php } ?>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">
                        <i class="fas fa-info-circle me-2"></i>Class Description
                    </label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter class description"><?= $description ?></textarea>
                    <?php if (isset($description_error) && $description_error !== "Complete.") { ?>
                        <div class="text-danger small mt-1"><?= $description_error ?></div>
                    <?php } ?>
                </div>
                <div class="mb-3">
                    <label for="product_img" class="form-label">
                        <i class="fas fa-image me-2"></i>Class Images
                    </label>
                    <input type="file" name="image[]" multiple class="form-control" id="product_img" accept="image/*">
                    <div class="form-text">Select one or more images for the class (JPG, PNG only)</div>
                    <span class="error_msg text-danger"></span>
                </div>

                <input type="hidden" name="form_sub" value="1">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Create Class
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('../adminLayout/footer.php'); ?>