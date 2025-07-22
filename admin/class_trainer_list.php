<?php
$current_user = json_decode($_COOKIE["user"], true);
$user_role = $current_user['role'] ?? 0;
if ($user_role != "admin") {
    header("location:../home.php");
    exit;
}
require '../storage/db.php';
require '../storage/central_function.php';

// $limit = 10;
// $page = isset($_GET['pageNo']) ? intval($_GET['pageNo']) : 1;
// $offset = ($page - 1) * $limit;
// $numberTitle = ($page * $limit) - $limit;

$row = select_data('class_trainer', $conn, '*');

// $row_count = COUNT($row->fetch_all()); //get number of users
// $pagination_link = ceil($row_count / 10);
// $users = getDataWithOffset('member', $mysql, $offset, $limit);
$delete_id = isset($_GET['delete_id']) ?  $_GET['delete_id'] : '';
if ($delete_id !== '') {
    $res = deleteData('class', $conn, "class_trainer_id=$delete_id");

    if ($res) {
        header("Location: ../admin/class_trainer_list.php?success=Successfully deleted");
        exit;
    }
}

?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php
require_once('../adminLayout/header1.php'); ?>



<div class="container mt-4 fade-in-up">

    <div class="card text-center">
        <div class="card-header">
            <h3><i class="fas fa-users me-2"></i>Class List</h3>
        </div>
        <div class="card-body">
            <!-- Add table-responsive class -->
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Class</th>
                            <th scope="col">Trainer</th>
                            <th scope="col">Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($row->num_rows > 0) {
                            while ($show = $row->fetch_assoc()) {
                                // Fetch class name for this class trainer
                                $class_sql = "SELECT class_name FROM class WHERE class_id='" . $show['class_id'] . "' LIMIT 1";
                                $class_result = $conn->query($class_sql);
                                $class_name = '';
                                if ($class_result && $class_result->num_rows > 0) {
                                    $class_row = $class_result->fetch_assoc();
                                    $class_name = $class_row['class_name'];
                                }
                                // Fetch trainer for this class
                                $trainer_sql = "SELECT trainer_name FROM trainer WHERE trainer_id='" . $show['trainer_id'] . "' LIMIT 1";
                                $trainer_result = $conn->query($trainer_sql);
                                $trainer_name = '';
                                if ($trainer_result && $trainer_result->num_rows > 0) {
                                    $trainer_row = $trainer_result->fetch_assoc();
                                    $trainer_name = $trainer_row['trainer_name'];
                                }
                        ?>

                                <tr>
                                    <td><?= $show['class_trainer_id'] ?></td>
                                    <td><?= $class_name ?></td>
                                    <td><?= $trainer_name ?></td>
                                    <td><?= $show['price'] ?> dollars</td>
                                    <td>
                                        <a href="<?= '../admin/class_edit.php?id=' . $show['class_id'] ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit me-1"></i>
                                        </a>
                                        <button data-id="<?= $show['class_id'] ?>" class="btn btn-sm btn-danger delete_btn">
                                            <i class="fas fa-trash me-1"></i>
                                        </button>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<?php include_once('../adminLayout/footer.php'); ?>

<script>
    $(document).ready(function() {
        $('.delete_btn').click(function() {
            const id = $(this).data('id')

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'class_list.php?delete_id=' + id
                }
            });
        })
    })
</script>