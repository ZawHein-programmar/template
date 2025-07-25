<?php
$current_user = json_decode($_COOKIE["user"], true);
$user_role = $current_user['role'] ?? 0;
if ($user_role != "admin") {
    header("location:../home.php");
    exit;
}
require '../storage/db.php';
require '../storage/central_function.php';

$success = $_GET['success'] ? $_GET['success']  : '';

// $limit = 10;
// $page = isset($_GET['pageNo']) ? intval($_GET['pageNo']) : 1;
// $offset = ($page - 1) * $limit;
// $numberTitle = ($page * $limit) - $limit;

$row = select_data('member', $conn, '*');
// var_dump($row);
// die();
// $row_count = COUNT($row->fetch_all()); //get number of users
// $pagination_link = ceil($row_count / 10);
// $users = getDataWithOffset('member', $mysql, $offset, $limit);
$delete_id = isset($_GET['delete_id']) ?  $_GET['delete_id'] : '';
if ($delete_id !== '') {
    $res = deleteData('member', $conn, "member_id=$delete_id");

    if ($res) {
        header("Location: ../admin/member_list.php?success=Successfully deleted");
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
            <h3><i class="fas fa-users me-2"></i>Member List</h3>
        </div>
        <div class="card-body">
            <!-- Add table-responsive class -->
            <div class="table-responsive">
                <?php if ($success !== '') { ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i><?= $success ?>
                    </div>
                <?php } ?>
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">DOB</th>
                            <th scope="col">Address</th>
                            <th scope="col">Gender</th>
                            <th scope="col">join_date</th>
                            <th scope="col">original_weight</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($row->num_rows > 0) {
                            while ($show = $row->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $show['member_id'] ?></td>
                                    <td><?= $show['member_name'] ?></td>
                                    <td><?= $show['email'] ?></td>
                                    <td><?= $show['phone'] ?></td>
                                    <td><?= $show['DOB'] ?></td>
                                    <td><?= $show['address'] ?></td>
                                    <td><?= $show['gender'] ?></td>
                                    <td><?= date("d-F-Y", strtotime($show['join_date'])) ?></td>
                                    <td><?= $show['original_weight'] ?></td>
                                    <td>
                                        <a href="<?= '../admin/member_edit.php?id=' . $show['member_id'] ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit me-1"></i>
                                        </a>
                                        <button data-id="<?= $show['member_id'] ?>" class="btn btn-sm btn-danger delete_btn">
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
                    window.location.href = 'member_list.php?delete_id=' + id
                }
            });
        })
    })
</script>