<?php

session_start();

require_once __DIR__ . "/../Config/database.php";
require_once __DIR__ . "/../Models/User.php";

$user = new User($conn);

if (isset($_POST['register'])) {

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($fullname) || empty($email) || empty($password) || empty($confirmPassword)) {
        die("All fields are required!");
    }

    if ($password !== $confirmPassword) {
        die("Passwords do not match!");
    }

    if ($user->emailExists($email)) {
        die("Email already exists!");
    }

    if ($user->register($fullname, $email, $password)) {

    header("Location: ../Views/Auth/login.php?registered=1");
    exit();

} else {

    die("Registration Failed!");

}
}


if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $userData = $user->login($email);

    if($userData && password_verify($password, $userData['password'])){

        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['user_name'] = $userData['full_name'];

        header("Location: ../Views/dashboard/dashboard.php");
        exit();

    }else{

        die("Invalid Email or Password!");

    }

}