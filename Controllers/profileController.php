<?php

session_start();

require_once "../Config/database.php";
require_once "../Models/User.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Views/Auth/login.php");
    exit();
}

$user = new User($conn);

$user_id = $_SESSION['user_id'];


// =========================
// Update Profile
// =========================

if (isset($_POST['updateProfile'])) {

    $full_name = trim($_POST['full_name']);

    if (empty($full_name)) {

        $_SESSION['profile_error'] = "Full name is required.";

        header("Location: ../Views/profile/edit.php");

        exit();
    }

    if ($user->updateProfile($user_id, $full_name)) {

        $_SESSION['user_name'] = $full_name;

        $_SESSION['profile_success'] = "Profile updated successfully.";

    } else {

        $_SESSION['profile_error'] = "Unable to update profile.";

    }

    header("Location: ../Views/profile/profile.php");

    exit();
}



// =========================
// Change Password
// =========================

if (isset($_POST['changePassword'])) {

    $current_password = $_POST['current_password'];

    $new_password = $_POST['new_password'];

    $confirm_password = $_POST['confirm_password'];

    if (
        empty($current_password) ||
        empty($new_password) ||
        empty($confirm_password)
    ) {

        $_SESSION['profile_error'] = "Please fill all password fields.";

        header("Location: ../Views/profile/edit.php");

        exit();
    }

    if ($new_password != $confirm_password) {

        $_SESSION['profile_error'] = "New passwords do not match.";

        header("Location: ../Views/profile/edit.php");

        exit();
    }

    if (!$user->verifyPassword($user_id, $current_password)) {

        $_SESSION['profile_error'] = "Current password is incorrect.";

        header("Location: ../Views/profile/edit.php");

        exit();
    }

    if ($user->changePassword($user_id, $new_password)) {

        $_SESSION['profile_success'] = "Password changed successfully.";

    } else {

        $_SESSION['profile_error'] = "Unable to change password.";

    }

    header("Location: ../Views/profile/profile.php");

    exit();
}