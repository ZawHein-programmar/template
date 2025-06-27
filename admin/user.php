<?php
require_once '../storage/db.php';
require_once '../storage/userCrud.php';

if (isset($_GET['deleteId'])) {
    $deleteId = $_GET['deleteId'];
    $status = delete_user($conn, $deleteId);
    if ($status == 1) {
        $message = "User successfully deleted";
    } else {
        $message = $status;
    }
}

$limit = 10;
$page = isset($_GET['pageNo']) ? intval($_GET['pageNo']) : 1;
$offset = ($page - 1) * $limit;
$numberTitle = ($page * $limit) - $limit;

$row = get_all_users($conn);
$row_count = COUNT($row->fetch_all()); //get number of users
$pagination_link = ceil($row_count / 10);
$users = get_user_with_offset($conn, $offset, $limit);
?>
<div class="container">
    <?php if (isset($message)) { ?>
        <div class="alert alert-warning alert-dismissible fade mx-auto show w-75 mt-2 mb-2" role="alert">
            <strong><?= $message ?></strong>
            <button type="button" class=" btn-close close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
    <?php } ?>
    <?php if (isset($_GET['deleteError'])) {
        $deleteId = $_GET['deleteError'];
    ?>
        <div class="alert alert-warning alert-dismissible fade mx-auto show w-75 mt-2 mb-2" role="alert">
            <strong>The id <?= $deleteId ?> is not equal to the user you choose</strong>
            <button type="button" class=" btn-close close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
    <?php } ?>
    <div class="card text-center">
        <div class="card-header">
            <h3>User List</h3>
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
                            <th scope="col">Address</th>
                            <th scope="col">Role</th>
                            <th scope="col">Profile</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $users->fetch_assoc()) {
                        ?>
                            <tr>
                                <th scope="row"><?= $numberTitle ?></th>
                                <td><?= $row['user_name'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td><?= $row['phone'] ?></td>
                                <td><?= $row['address'] ?></td>
                                <td><?php if ($row['role'] == "1") {
                                        echo  "User";
                                    } else {
                                        echo  "Admin";
                                    } ?></td>
                                <td><a href="#"><?= $row['profile'] ?></a></td>
                                <td>
                                    <button class="btn btn-sm btn-danger me-1">Edit</button>
                                    <?php if ($row['email'] == $current_user['email']) { ?>
                                    <?php } else { ?>
                                        <button class="btn btn-sm btn-danger deleteUser" data-value="<?= $row['user_id'] ?>"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"><i
                                                class="fa fa-trash"></i></button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php
                            $numberTitle++;
                        } ?>

                    </tbody>
                </table>
                <?php if (!($row_count <= $limit)) { ?>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php if ($page <= 1)
                                                        echo 'disabled' ?>">
                                <a class="page-link"
                                    href="?pageNo=<?= $page - 1; ?>&search_data=<?= isset($searchData) ? urlencode($searchData) : ''; ?>">Previous</a>
                            </li>
                            <?php $j = 1;
                            while ($pagination_link >= $j) { ?>
                                <li class="page-item">
                                    <a class="page-link <?php if ($page == $j)
                                                            echo 'active' ?>"
                                        href="?pageNo=<?= $j ?>&search_data=<?= isset($searchData) ? urlencode($searchData) : ''; ?>"><?php echo $j; ?></a>
                                </li>
                            <?php $j++;
                            } ?>
                            <li class="page-item <?php if ($pagination_link == $page)
                                                        echo 'disabled' ?>">
                                <a class="page-link"" href=" ?pageNo=<?= $page + 1; ?>&search_data=<?= isset($searchData) ? urlencode($searchData) : ''; ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-md" id="deleteModal" tabindex="-1">
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
                <button type="button" class="btn btn-sm btn-primary" id="deleteBtn">OK</button>
            </div>
        </div>
    </div>
</div>