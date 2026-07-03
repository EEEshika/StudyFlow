<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Auth/login.php");
    exit();
}

require_once "../../Config/database.php";
require_once "../../Models/User.php";

$userModel = new User($conn);
$user = $userModel->getUserById($_SESSION['user_id']);

include "../../Includes/header.php";

?>

<div class="dashboard">

<?php include "../../Includes/sidebar.php"; ?>

<div class="dashboard-main">

<div class="profile-container">

<h1>Edit Profile</h1>

<?php if(isset($_SESSION['profile_error'])) : ?>

<div class="error-message">

<?= $_SESSION['profile_error']; ?>

</div>

<?php unset($_SESSION['profile_error']); ?>

<?php endif; ?>

<?php if(isset($_SESSION['profile_success'])) : ?>

<div class="success-message">

<?= $_SESSION['profile_success']; ?>

</div>

<?php unset($_SESSION['profile_success']); ?>

<?php endif; ?>

<div class="profile-card">

<h2>Update Profile</h2>

<form
class="profile-form"
action="../../Controllers/profileController.php"
method="POST">

<label>Full Name</label>

<input
type="text"
name="full_name"
value="<?= htmlspecialchars($user['full_name']); ?>"
required>

<label>Email</label>

<input
type="email"
value="<?= htmlspecialchars($user['email']); ?>"
disabled>

<button
type="submit"
name="updateProfile">

Update Profile

</button>

</form>

<hr style="margin:40px 0;">

<h2>Change Password</h2>

<form
class="profile-form"
action="../../Controllers/profileController.php"
method="POST">

<label>Current Password</label>

<input
type="password"
name="current_password"
required>

<label>New Password</label>

<input
type="password"
name="new_password"
required>

<label>Confirm Password</label>

<input
type="password"
name="confirm_password"
required>

<button
type="submit"
name="changePassword">

Change Password

</button>

</form>

</div>

</div>

</div>

</div>

<?php include "../../Includes/footer.php"; ?>