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
$success = $_GET['success'] ? $_GET['success']  : '';
$select_member_class = select_data('member_class', $conn, '*');

// $row_count = COUNT($row->fetch_all()); //get number of users
// $pagination_link = ceil($row_count / 10);
// $users = getDataWithOffset('member', $mysql, $offset, $limit);
$delete_id = isset($_GET['delete_id']) ?  $_GET['delete_id'] : '';
if ($delete_id !== '') {
    $res = deleteData('member_class', $conn, "member_class_id=$delete_id");

    if ($res) {
        header("Location: ../admin/member_class_list.php?success=Successfully deleted");
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


<div class="d-flex justify-content-end mt-3">
    <button onclick="window.history.back()" class="btn btn-glass">
        <i class="fa-solid fa-arrow-left me-2"></i>Back
    </button>
</div>
<div class="container mt-4 fade-in-up">

    <div class="card text-center" style="background: var(--glass-bg); border-radius: 20px; box-shadow: var(--glass-shadow); border: 1.5px solid var(--glass-border); overflow: hidden;">
        <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.12);">
            <h3><i class="fas fa-users me-2" style="color: var(--text-primary); font-weight: 600;"></i>Class Member List</h3>
        </div>
        <div class="card-body">
            <!-- Add table-responsive class -->
            <?php if ($success !== '') { ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i><?= $success ?>
                </div>
            <?php } ?>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Member Name</th>
                            <th scope="col">Class Details</th>
                            <th scope="col">Enroll Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $select_member_class->fetch_assoc()):
                            //selecting member name from member table
                            $select_member = "SELECT member_name FROM member WHERE member_id='" . $row['member_id'] . "' LIMIT 1";
                            $member_rsult = $conn->query($select_member);
                            $member_name = '';
                            if ($member_rsult && $member_rsult->num_rows > 0) {
                                $member_row = $member_rsult->fetch_assoc();
                                $member_name = $member_row['member_name'];
                            }

                            // selecting class trainer details
                            $select_class_trainer = "SELECT * FROM class_trainer WHERE class_trainer_id='" . $row['class_trainer_id'] . "' LIMIT 1";
                            $class_trainer_result = $conn->query($select_class_trainer);
                            $class_id = '';
                            $trainer_id = '';
                            if ($class_trainer_result && $class_trainer_result->num_rows > 0) {
                                $clss_trainer_row = $class_trainer_result->fetch_assoc();
                                $class_id = $clss_trainer_row['class_id'];
                                $trainer_id = $clss_trainer_row['trainer_id'];
                            }

                            // selecting class name from class table
                            $select_class = "SELECT class_name FROM class WHERE class_id='" . $class_id . "' LIMIT 1";
                            $class_result = $conn->query($select_class);
                            $class_name = '';
                            if ($class_result && $class_result->num_rows > 0) {
                                $class_row = $class_result->fetch_assoc();
                                $class_name = $class_row['class_name'];
                            }

                            // selecting trainer name from trainer table
                            $select_trainer = "SELECT trainer_name FROM trainer WHERE trainer_id='" . $trainer_id . "' LIMIT 1";
                            $trainer_result = $conn->query($select_trainer);
                            $trainer_name = '';
                            if ($trainer_result && $trainer_result->num_rows > 0) {
                                $trainer_row = $trainer_result->fetch_assoc();
                                $trainer_name = $trainer_row['trainer_name'];
                            }
                        ?>
                            <tr>
                                <td><?= $row['member_class_id'] ?></td>
                                <td><?= $member_name ?></td>
                                <td><?= $class_name ?> by <?= $trainer_name ?></td>
                                <td> <?= $row['enrolled_date'] ?></td>
                                <td>
                                    <a href="<?= '../admin/member_class_edit.php?id=' . $row['member_class_id'] ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit me-1"></i>
                                    </a>
                                    <button data-id="<?= $row['member_class_id'] ?>" class="btn btn-sm btn-danger delete_btn">
                                        <i class="fas fa-trash me-1"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
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