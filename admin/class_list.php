<?php
$current_user = json_decode($_COOKIE["user"], true);
$user_role = $current_user['role'] ?? 0;
if ($user_role != "admin") {
    header("location:../home.php");
    exit;
}
require '../storage/db.php';
require '../storage/central_function.php';

$limit = 5;
$page = isset($_GET['pageNo']) ? intval($_GET['pageNo']) : 1;
$offset = ($page - 1) * $limit;
$numberTitle = ($page * $limit) - $limit;

$success = $_GET['success'] ? $_GET['success']  : '';
$row = getDataWithOffset('class', $conn, $offset, $limit);


$total_result = select_data('class', $conn, 'COUNT(*) AS total');
$total_row = $total_result->fetch_assoc();
$row_count = $total_row['total'];
$pagination_link = ceil($row_count / $limit);

// $users = getDataWithOffset('member', $conn, $offset, $limit);

$delete_id = isset($_GET['delete_id']) ?  $_GET['delete_id'] : '';
if ($delete_id !== '') {
    $res = deleteData('class', $conn, "class_id=$delete_id");

    if ($res) {
        header("Location: ../admin/class_list.php?success=Successfully deleted");
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
            <h3><i class="fas fa-users me-2" style="color: var(--text-primary); font-weight: 600;"></i>Class List</h3>
        </div>
        <div class="card-body">
            <!-- Add table-responsive class -->
            <div class="table-responsive">
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
                                <th scope="col">Classes</th>
                                <th scope="col">Description</th>
                                <th scope="col">Image</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($row->num_rows > 0) {
                                while ($show = $row->fetch_assoc()) {
                                    // Fetch image for this class
                                    $img_sql = "SELECT img FROM image WHERE type='class' AND target_id='" . $show['class_id'] . "' LIMIT 1";
                                    $img_result = $conn->query($img_sql);
                                    $img_path = '';
                                    if ($img_result && $img_result->num_rows > 0) {
                                        $img_row = $img_result->fetch_assoc();
                                        $img_path = $img_row['img'];
                                    }
                            ?>
                                    <tr>
                                        <td><?= $numberTitle + 1 ?></td>
                                        <td><?= $show['class_name'] ?></td>
                                        <td><?= $show['description'] ?></td>
                                        <td>
                                            <?php if ($img_path) { ?>
                                                <img src="<?= htmlspecialchars($img_path) ?>" alt="Class Image" style="width:60px;height:60px;object-fit:cover;">
                                            <?php } else { ?>
                                                <span class="text-muted">No image</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="<?= '../admin/class_edit.php?id=' . $show['class_id'] ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit me-1"></i>
                                            </a>
                                            <button data-id="<?= $show['class_id'] ?>" class="btn btn-sm btn-danger delete_btn">
                                                <i class="fas fa-trash me-1"></i>
                                            </button>
                                        </td>
                                        <?php $numberTitle++ ?>

                                    </tr>

                            <?php }
                            } ?>
                        </tbody>
                    </table>
                    <!-- Custom Glassmorphic Pagination -->
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-end gap-2 align-items-center" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); padding: 8px 12px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.2);">

                            <!-- Previous Button -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?pageNo=<?= $page - 1 ?>" style="border-radius: 10px; background: rgba(255,255,255,0.2); color: #fff; border: none;">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </a>
                            </li>

                            <!-- Numbered Page Buttons -->
                            <?php for ($i = 1; $i <= $pagination_link; $i++): ?>
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                    <a class="page-link" href="?pageNo=<?= $i ?>" style="border-radius: 10px; background: <?= ($i == $page) ? 'rgba(0,123,255,0.6)' : 'rgba(255,255,255,0.15)' ?>; color: #fff; border: none;">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next Button -->
                            <li class="page-item <?= ($page >= $pagination_link) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?pageNo=<?= $page + 1 ?>" style="border-radius: 10px; background: rgba(255,255,255,0.2); color: #fff; border: none;">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </li>

                        </ul>
                    </nav>



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