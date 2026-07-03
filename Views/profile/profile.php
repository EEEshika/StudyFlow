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

            <h1>My Profile</h1>

            <br>

            <?php if(isset($_SESSION['profile_success'])) : ?>

                <div class="success-message">

                    <?= $_SESSION['profile_success']; ?>

                </div>

                <?php unset($_SESSION['profile_success']); ?>

            <?php endif; ?>

            <?php if(isset($_SESSION['profile_error'])) : ?>

                <div class="error-message">

                    <?= $_SESSION['profile_error']; ?>

                </div>

                <?php unset($_SESSION['profile_error']); ?>

            <?php endif; ?>

            <div class="profile-card">

                <div class="profile-header">

                    <img
                    src="../../Assets/images/profile/default.png"
                    alt="Profile">

                    <h2>

                        <?= htmlspecialchars($user['full_name']); ?>

                    </h2>

                </div>

                <table class="profile-info">

                    <tr>

                        <td>Full Name</td>

                        <td>

                            <?= htmlspecialchars($user['full_name']); ?>

                        </td>

                    </tr>

                    <tr>

                        <td>Email</td>

                        <td>

                            <?= htmlspecialchars($user['email']); ?>

                        </td>

                    </tr>

                    <tr>

                        <td>Member Since</td>

                        <td>

                            <?= date("d M Y", strtotime($user['created_at'])); ?>

                        </td>

                    </tr>

                </table>

                <div class="profile-actions">

                    <a
                    href="edit.php"
                    class="profile-btn">

                        Edit Profile

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../../Includes/footer.php"; ?>