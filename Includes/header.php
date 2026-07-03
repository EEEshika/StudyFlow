<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>StudyFlow</title>

<link rel="stylesheet" href="../../Assets/css/style.css">

<?php
$currentFolder = basename(dirname($_SERVER['PHP_SELF']));

if ($currentFolder == "Auth") {
    echo '<link rel="stylesheet" href="../../Assets/css/auth.css">';
}

if ($currentFolder == "dashboard") {
    echo '<link rel="stylesheet" href="../../Assets/css/dashboard.css">';
}

if ($currentFolder == "task") {
    echo '<link rel="stylesheet" href="../../Assets/css/task.css">';
}

if ($currentFolder == "subject") {
    echo '<link rel="stylesheet" href="../../Assets/css/subject.css">';
}

if ($currentFolder == "profile") {
    echo '<link rel="stylesheet" href="../../Assets/css/profile.css">';
}
?>


</body>
</html>