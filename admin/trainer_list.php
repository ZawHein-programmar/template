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

$row = select_data('trainer', $conn, '*');
// var_dump($row);
// die();
// $row_count = COUNT($row->fetch_all()); //get number of users
// $pagination_link = ceil($row_count / 10);
// $users = getDataWithOffset('member', $mysql, $offset, $limit);
$delete_id = isset($_GET['delete_id']) ?  $_GET['delete_id'] : '';
if ($delete_id !== '') {
    $res = deleteData('trainer', $conn, "trainer_id=$delete_id");

    if ($res) {
        header("Location: ../admin/trainer_list.php?success=Successfully deleted");
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



<div class="container mt-4">

    <div class="card text-center">
        <div class="card-header">
            <h3>Trainer List</h3>
        </div>
        <div class="card-body">
            <!-- Add table-responsive class -->
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Specialty</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Bio</th>
                            <th scope="col">join_date</th>
                            <th scope="col">created_at</th>
                            <th scope="col">updated_at</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($row->num_rows > 0) {
                            while ($show = $row->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $show['trainer_id'] ?></td>
                                    <td><?= $show['trainer_name'] ?></td>
                                    <td><?= $show['email'] ?></td>
                                    <td><?= $show['phone'] ?></td>
                                    <td><?= $show['specialty'] ?></td>
                                    <td><?= $show['gender'] ?></td>
                                    <td><?= $show['bio'] ?></td>
                                    <td><?= date("Y-m-d g:i:s A", strtotime($show['join_date'])) ?></td>
                                    <td><?= date("Y-m-d g:i:s A", strtotime($show['updated_at'])) ?></td>
                                    <td><?= date("Y-m-d g:i:s A", strtotime($show['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= '../admin/trainer_edit.php?id=' . $show['trainer_id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <button data-id="<?= $show['trainer_id'] ?>" class="btn btn-sm btn-danger delete_btn">Delete</button>
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
<!-- <div class="modal modal-md" id="deleteModal" tabindex="-1">
    <div class="modal-dialog w-100">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation Message</h5>
                <button type="button" class="btn-close btn-sm" id="closeBtn" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure to delete..</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-primary" id="delete_btn">OK</button>
            </div>
        </div>
    </div>
</div> -->

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