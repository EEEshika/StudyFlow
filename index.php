<?php

session_start();

if(isset($_SESSION['user_id'])){
    header("Location: Views/dashboard/dashboard.php");
}else{
    header("Location: Views/Auth/login.php");
}

exit();