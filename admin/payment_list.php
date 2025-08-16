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

$select_payment = select_data('payment', $conn, '*');

// $row_count = COUNT($row->fetch_all()); //get number of users
// $pagination_link = ceil($row_count / 10);
// $users = getDataWithOffset('member', $mysql, $offset, $limit);
$delete_id = isset($_GET['delete_id']) ?  $_GET['delete_id'] : '';
if ($delete_id !== '') {
    $res = deleteData('payment', $conn, "payment_id=$delete_id");

    if ($res) {
        header("Location: ../admin/payment_list.php?success=Successfully deleted");
        exit;
    }
}

?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Bootstrap Bundle with Popper (required for modals to work) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




<style>
    .header {
        /* background: url('./images/gymgirls.png') no-repeat right/contain; */
        display: flex;
        height: 200px;
        position: relative;
        color: white;
        padding: 30px 0px;
        /* background-color: white; */
    }

    .header .text {
        width: 60%;
        align-items: start;
        justify-content: start;
    }

    .header>.img {
        position: absolute;
        bottom: 5px;
        right: 10px;
        width: 40%;
        margin: auto;

    }

    .img img {
        width: 300px;
        height: auto;
        object-fit: cover;
    }

    .header h1 {
        /* margin: 0; */
        font-size: 36px;
    }

    .header .details {
        position: absolute;
        bottom: 10px;
        left: 0px;
        background: rgba(0, 0, 0, 0.7);
        padding: 10px 20px;
        border-left: 5px solid #b6ff00;
    }

    .header .details div {
        margin-bottom: 5px;
    }

    .section-title {
        background: #b6ff00;
        color: black;
        padding: 10px;
        font-weight: bold;
        font-size: 16px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #b6ff00;
        color: black;
        padding: 12px;
        text-align: left;
    }

    td {
        background: #111;
        padding: 12px;
    }

    .summary {
        text-align: right;
        margin-top: 20px;
        padding: 20px;
    }

    table #thead-inv {
        border: 1px solid #b6ff00;
        border-bottom: none;
        border-top: none;
    }

    #inv-content {
        border: 1px solid #b6ff00;
        border-top: none;
    }

    #inv-content tr {
        border-bottom: 1px solid #b6ff00;
    }

    #inv-content tr td {
        border-right: 1px solid #b6ff00;
    }

    .summary div {
        margin: 8px 0;
        /* border: 1px solid whitesmoke; */
    }

    .total {
        background: #b6ff00;
        color: black;
        font-weight: bold;
        padding: 12px;
        display: inline-block;
        min-width: 200px;
        align-items: left;
    }

    .footer {
        display: flex;
        justify-content: space-between;
        padding: 20px;
        background: url('./images/footer.jpg') no-repeat center/cover;
        color: white;
        font-size: 13px;
    }

    .footer div {
        background: rgba(0, 0, 0, 0.7);
        padding: 15px;
        width: 48%;
    }

    .footer a {
        color: #b6ff00;
        text-decoration: none;
        font-weight: bold;
    }
</style>

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
            <h3><i class="fas fa-users me-2" style="color: var(--text-primary); font-weight: 600;"></i>Payment List</h3>
        </div>
        <div class="card-body">
            <!-- Add table-responsive class -->
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Member</th>
                            <th scope="col">Class</th>
                            <th scope="col">Trainer</th>
                            <th scope="col">Date</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $select_payment->fetch_assoc()):
                            //selecting payment from member table
                            $select_member_class = "SELECT * FROM member_class WHERE member_class_id='" . $row['member_class_id'] . "' LIMIT 1";
                            $member_class_rsult = $conn->query($select_member_class);
                            if ($member_class_rsult && $member_class_rsult->num_rows > 0) {
                                $member_class_row = $member_class_rsult->fetch_assoc();
                                $member_id = $member_class_row['member_id'];
                            }

                            $select_member = "SELECT member_name FROM member WHERE member_id='" . $member_id . "' LIMIT 1";
                            $member_result = $conn->query($select_member);
                            $member_name = '';
                            if ($member_result && $member_result->num_rows > 0) {
                                $member_row = $member_result->fetch_assoc();
                                $member_name = $member_row['member_name'];
                            }

                            // selecting class trainer details
                            $select_class_trainer = "SELECT * FROM class_trainer WHERE class_trainer_id='" . $member_class_row['class_trainer_id'] . "' LIMIT 1";
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

                            //selecting discount detail
                            $select_discount_detail = "SELECT * FROM discount_detail WHERE discount_detail_id='" . $row['discount_detail_id'] . "' LIMIT 1";
                            $discount_detail_result = $conn->query($select_discount_detail);
                            $discount_id = '';
                            if ($discount_detail_result && $discount_detail_result->num_rows > 0) {
                                $discount_row = $discount_detail_result->fetch_assoc();
                                $discount_id = $discount_row['discount_id'];
                            }

                            // selecting discount name from discount table
                            $select_discount = "SELECT * FROM discount WHERE discount_id='" . $discount_id . "' LIMIT 1";
                            $discount_result = $conn->query($select_discount);
                            $discount_name = '';
                            if ($discount_result && $discount_result->num_rows > 0) {
                                $discount_row = $discount_result->fetch_assoc();
                                $discount_name = $discount_row['name_of_package'];
                                $percentage = $discount_row['percentage'] ? " (" . $discount_row['percentage'] . "%)" : '';
                            }
                        ?>
                            <tr>
                                <td><?= $row['member_class_id'] ?></td>
                                <td><?= $member_name ?></td>
                                <td><?= $class_name ?></td>
                                <td><?= $trainer_name ?></td>
                                <td><?= date("d-F-Y", strtotime($row['payment_date'])) ?></td>
                                <td> <?= $discount_name ?><?= $percentage ?></td>
                                <td><i class="fas fa-dollar me-2"></i><?= $row['amount'] ?></td>
                                <td>
                                    <a href="<?= '../admin/payment_edit.php?id=' . $row['payment_id'] ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit me-1"></i>
                                    </a>
                                    <button data-id="<?= $row['payment_id'] ?>" class="btn btn-sm btn-danger delete_btn">
                                        <i class="fas fa-trash me-1"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary receipt-btn" data-val="<?= $row['payment_id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                                        <i class="fa-regular fa-file-lines"></i>
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


<!-- Modal -->
<div class="modal fade modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Gym Fit Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid bg-dark" id="inv-print">
                    <div class="header">
                        <div class="text">
                            <h1 class="mb-3"><span style="color: #b6ff00;">GYM FIT</span> INVOICE</h1>
                            <div class="details">
                                <div>Date: <span id="inv-date"></span>
                                </div>
                                <div>Invoice Number: <span id="inv-nov"></span></div>
                                <div>Name : <span id="inv-name"></span></div>
                            </div>
                        </div>
                        <div class="img">
                            <img src="./images/gymgirls.png" alt="Gym Fit Logo">
                        </div>
                    </div>

                    <!-- <div class="section-title">Item Description</div> -->
                    <table>
                        <thead id="thead-inv">
                            <tr>
                                <th>No</th>
                                <th>Class</th>
                                <th>Trainer</th>
                                <th>Discount</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody id="inv-content" class="text-light">
                            <!-- JS will fill rows here -->
                        </tbody>
                    </table>

                    <div class="summary" id="invoice-summary">
                        <!-- JS will fill summary here -->
                    </div>

                    <div class="footer">
                        <div>
                            <strong>PAYMENT METHOD</strong><br>
                            By Bank<br>
                            BB33 00 1234EE
                        </div>
                        <div>
                            <strong>TERMS AND CONDITIONS</strong><br>
                            <br><br>
                            <a href="https://www.yoursite.com">Visit our website www.yoursite.com</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printInvoice()">Print Out</button>
            </div>
        </div>
    </div>
</div>

<?php
//include_once('../adminLayout/footer.php'); 
?>

<script>
    function printInvoice() {
        const invoice = document.getElementById('inv-print'); // Your invoice modal
        const printWindow = window.open('', '', 'width=1000,height=600');
        printWindow.document.write(`
        <html>
            <head>
                <title>Print Invoice</title>
                <style>
                    @media print {
                        @page {
                            size: A5;
                            margin: 10mm;
                        }
                        body {
                            font-family: Arial, sans-serif;
                            background: black;
                            color: white;
                            font-size: 12pt;
                            max-width: 100%;
                        }
                            .header {
        height: 120px;
        position: relative;
        color: white;
        padding: 10px 0px;
    }

    .header h1 {
        font-size: 18px;
    }

    .header .details {
        background: rgba(0, 0, 0, 0.7);
        padding: 10px 20px;
        border-left: 5px solid #b6ff00;
    }
        .header .text {
        width: 60%;
        align-items: start;
        justify-content: start;
    }

    .header>.img {
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 40%;
        margin: auto;

    }

    .img img {
        width: 200px;
        height: auto;
        object-fit: cover;
    }
        .section-title {
        background: #b6ff00;
        color: black;
        font-weight: bold;
        font-size: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #b6ff00;
        color: black;
        padding: 10px;
        text-align: left;
    }

    td {
        background: #111;
        padding: 10px;
    }

    table thead {
        border: 1px solid #b6ff00;
        border-top:none;
        border-bottom:none;
    }

    .summary {
        text-align: right;
        margin-top: 5px;
        padding: 20px;
        color: white;
    }

    #inv-content {
        border: 1px solid #b6ff00;
        border-top: none;
    }
    
    #inv-content tr {
        border-bottom: 1px solid #b6ff00;
    }

    #inv-content tr td {
        border-right: 1px solid #b6ff00;
    }

    .summary div {
        margin: 8px 0;
        /* border: 1px solid whitesmoke; */
    }

    .total {
        background: #b6ff00;
        color: black;
        font-weight: bold;
        padding: 12px;
        display: inline-block;
        min-width: 200px;
        align-items: left;
    }

    .footer {
        display: flex;
        justify-content: space-between;
        padding: 20px;
        background: url('./images/footer.jpg') no-repeat center/cover;
        color: white;
        font-size: 13px;
    }

    .footer div {
        background: rgba(0, 0, 0, 0.7);
        padding: 15px;
        width: 48%;
    }

    .footer a {
        color: #b6ff00;
        text-decoration: none;
        font-weight: bold;
    }
                        
                    }
                </style>
            </head>
            <body>${invoice.outerHTML}</body>
        </html>
    `);

        printWindow.document.close();
        printWindow.focus();

        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 300);
    }

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
        $('.receipt-btn').on('click', function() {
            const inv_summary = $('#invoice-summary');

            // console.log($(this).data('val'));
            // Update modal content if needed
            $.ajax({
                url: 'get_receipt.php',
                type: 'GET',
                currentType: "application/json",
                dataType: 'json',
                data: {
                    payment_id: $(this).data('val')
                },
                success: function(response) {
                    let response_arr = response.payment
                    console.log(response_arr);
                    // const response_arr = Object.values(response.payment);
                    $('#inv-date').text(response.payment.payment_date);
                    $("#inv-nov").text("GF-" + response.payment.payment_id);
                    $('#inv-name').text(response.payment.member_name);

                    $('#inv-content').html('');
                    // response_arr.forEach(item => {
                    // console.log(item);

                    $('#inv-summary').html('');

                    $('#inv-content').html(`
<tr>
    <td>1</td>
    <td>${response_arr.class_name}</td>
    <td>${response_arr.trainer_name}</td>
    <td>${response_arr.name_of_package} (${response_arr.percentage}%)</td>
    <td>$${parseFloat(response_arr.amount).toFixed(2)}</td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>`)

                    $('#invoice-summary').html(`
<div class="text-light">Subtotal: $ ${response_arr.amount}</div>
<div class="total">Grand Total: $ ${response_arr.amount}</div>
`)
                    // });

                },
                error: function() {
                    $('.modal-body').html('<p>Error loading receipt.</p>');
                }
            });
        });
    })
</script>