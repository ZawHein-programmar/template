<?php

require 'databaserequire.php';
require 'common.php';
require 'central_function.php';

$success = isset($_GET['success']) ? $_GET['success'] : '';

//selecting data from table
$res = select_data('class', $mysql, '*', '', '');
$delete_id = isset($_GET['delete_id']) ?  $_GET['delete_id'] : '';
if ($delete_id !== '') {
    $res = deleteData('class', $mysql, "member_id=$delete_id");
    if ($res) {
        $url = $admin_base_url . "class_list.php?success=Delete Member Success";
        header("Location: $url");
        exit;
    }
}

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
                    <h1 class="text-lg text-white mt-2">Classes</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <h1>Class List</h1>
                <div class="">
                    <a href="<?= $admin_base_url . 'class_create.php' ?>" class="btn btn-sm btn-primary">
                        Create Class
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 offset-md-8 col-sm-6 offset-sm-6">
                    <!-- <?php if ($success !== '') { ?>
                    <div class="alert alert-success">
                        <?= $success ?>
                    </div> -->
                <?php } ?>
                <!-- <?php if ($error !== '') { ?>
                    <div class="alert alert-danger">
                        <?= $error ?>
                    </div>
                <?php } ?> -->
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th class="col-1">No.</th>
                                        <th class="col-2">Name</th>
                                        <th class="col-2">Phone</th>
                                        <th class="col-2">Address</th>
                                        <th class="col-2">Updated At</th>
                                        <th class="col-2">Created At</th>
                                        <th class="col-1">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($res->num_rows > 0) {
                                        while ($row = $res->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?= $row['member_id'] ?></td>
                                                <td><?= $row['member_name'] ?></td>
                                                <td><?= $row['phone'] ?></td>
                                                <td><?= $row['address'] ?></td>
                                                <td><?= date("Y-m-d g:i:s A", strtotime($row['updated_at'])) ?></td>
                                                <td><?= date("Y-m-d g:i:s A", strtotime($row['created_at'])) ?></td>
                                                <td>
                                                    <a href="<?= $admin_base_url . 'member_edit.php?id=' . $row['member_id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                                    <button data-id="<?= $row['member_id'] ?>" class="btn btn-sm btn-danger delete_btn">Delete</button>
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
        </div>
        <!-- #/ container -->
    </div>
    <!--**********************************
            Content body end
        ***********************************-->
    <?php
    require_once('footer.php');
    ?>

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