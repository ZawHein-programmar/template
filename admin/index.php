<?php
$current_user = json_decode($_COOKIE["user"], true);
$user_role = $current_user['role'] ?? 0;
if ($user_role != "admin") {
    header("location:../home.php");
    exit;
}
require '../storage/db.php';
require '../storage/central_function.php';

// Fetch counts from DB
$total_classes = 0;
$total_members = 0;
$total_trainers = 0;

// Classes
$class_result = $conn->query("SELECT COUNT(*) as cnt FROM class");
if ($class_result && $row = $class_result->fetch_assoc()) {
    $total_classes = $row['cnt'];
}
// Members
$member_result = $conn->query("SELECT COUNT(*) as cnt FROM member");
if ($member_result && $row = $member_result->fetch_assoc()) {
    $total_members = $row['cnt'];
}
// Trainers
$trainer_result = $conn->query("SELECT COUNT(*) as cnt FROM trainer");
if ($trainer_result && $row = $trainer_result->fetch_assoc()) {
    $total_trainers = $row['cnt'];
}

// Fetch latest 8 users
$user_list = [];
$user_query = $conn->query("SELECT id, name, email, created_at, status FROM member ORDER BY created_at DESC LIMIT 8");
if ($user_query) {
    while ($row = $user_query->fetch_assoc()) {
        $user_list[] = $row;
    }
}
?>
<?php require_once('../adminLayout/header1.php'); ?>

<div class="container-fluid mt-4">
    <div class="dashboard-cards">
        <div class="dashboard-card">
            <div class="card-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <div class="card-title">Total Classes</div>
            <div class="card-value"><?= $total_classes ?></div>
            <div class="mini-chart"></div>
        </div>
        <div class="dashboard-card">
            <div class="card-icon"><i class="fas fa-users"></i></div>
            <div class="card-title">Total Members</div>
            <div class="card-value"><?= $total_members ?></div>
            <div class="mini-chart"></div>
        </div>
        <div class="dashboard-card">
            <div class="card-icon"><i class="fas fa-user-tie"></i></div>
            <div class="card-title">Total Trainers</div>
            <div class="card-value"><?= $total_trainers ?></div>
            <div class="mini-chart"></div>
        </div>
        <!-- <div class="dashboard-card">
            <div class="card-icon"><i class="fas fa-dollar-sign"></i></div>
            <div class="card-title">Total Revenue This Year</div>
            <div class="card-value">9,503</div>
            <div class="mini-chart"></div>
        </div> -->
    </div>

    <!-- User List Table -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card p-0" style="background: var(--glass-bg); border-radius: 20px; box-shadow: var(--glass-shadow); border: 1.5px solid var(--glass-border); overflow: hidden;">
                <div class="card-header" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.12);">
                    <h5 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Recent Members</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Join Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($user_list) > 0): ?>
                                <?php foreach ($user_list as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['name']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= date('Y-m-d', strtotime($user['created_at'])) ?></td>
                                        <td>
                                            <?php if ($user['status'] == 'active'): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No members found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Sidebar toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const toggleIcon = document.getElementById('toggleIcon');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        if (toggleIcon) {
            toggleIcon.addEventListener('click', function() {
                sidebar.classList.toggle('hide');
                content.classList.toggle('full');
                sidebarBackdrop.classList.toggle('active');
            });
        }

        if (sidebarBackdrop) {
            sidebarBackdrop.addEventListener('click', function() {
                sidebar.classList.add('hide');
                content.classList.add('full');
                sidebarBackdrop.classList.remove('active');
            });
        }
    });
</script>

<?php include_once('../adminLayout/footer.php'); ?>