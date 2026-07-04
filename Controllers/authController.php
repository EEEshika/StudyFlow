<?php

session_start();

require_once __DIR__ . "/../Config/database.php";
require_once __DIR__ . "/../Models/User.php";

$user = new User($conn);

/* ===========================
   REGISTER
=========================== */

if (isset($_POST['register'])) {

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($fullname) || empty($email) || empty($password) || empty($confirmPassword)) {

        $_SESSION['register_error'] = "All fields are required!";
        header("Location: ../Views/Auth/register.php");
        exit();

    }

    if ($password !== $confirmPassword) {

        $_SESSION['register_error'] = "Passwords do not match!";
        header("Location: ../Views/Auth/register.php");
        exit();

    }

    if ($user->emailExists($email)) {

        $_SESSION['register_error'] = "Email already exists!";
        header("Location: ../Views/Auth/register.php");
        exit();

    }

    if ($user->register($fullname, $email, $password)) {

        header("Location: ../Views/Auth/login.php?registered=1");
        exit();

    } else {

        $_SESSION['register_error'] = "Registration Failed!";
        header("Location: ../Views/Auth/register.php");
        exit();

    }
}


/* ===========================
   LOGIN
=========================== */

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $userData = $user->login($email);

    if ($userData && password_verify($password, $userData['password'])) {

        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['user_name'] = $userData['full_name'];

        header("Location: ../Views/dashboard/dashboard.php");
        exit();

    } else {

        $_SESSION['login_error'] = "Invalid Email or Password!";
        header("Location: ../Views/Auth/login.php");
        exit();

    }

}