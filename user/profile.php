<?php
session_start();
require_once "common.php";
require_once "database/db.php";
require_once "auth/checkAuth.php";

// Fetch user info from session or DB
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header("Location: login.php");
    exit;
}

// Get user data from database
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    // User not found, handle gracefully
    echo "<div class='alert alert-danger'>User not found.</div>";
    include 'userLayout/footer.php';
    exit;
}

include 'userLayout/header1.php';
include 'userLayout/navbar.php';
include 'userLayout/sideBar.php';
?>

<div class="container mt-4">
    <h2 class="mb-4">My Profile</h2>
    <form action="profile_update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>">
        </div>

        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea name="bio" class="form-control"><?php echo htmlspecialchars($user['bio']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

<?php
include 'userLayout/footer.php';
?>