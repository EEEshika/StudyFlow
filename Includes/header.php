<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>StudyFlow</title>

<link rel="stylesheet" href="../../Assets/Css/style.css">

<?php
$currentFolder = basename(dirname($_SERVER['PHP_SELF']));

if ($currentFolder == "Auth") {
    echo '<link rel="stylesheet" href="../../Assets/Css/auth.css">';
}

if ($currentFolder == "dashboard") {
    echo '<link rel="stylesheet" href="../../Assets/Css/dashboard.css">';
}

if ($currentFolder == "task") {
    echo '<link rel="stylesheet" href="../../Assets/Css/task.css">';
}

if ($currentFolder == "subject") {
    echo '<link rel="stylesheet" href="../../Assets/Css/subject.css">';
}

if ($currentFolder == "profile") {
    echo '<link rel="stylesheet" href="../../Assets/Css/profile.css">';
}
?>


</body>
</html>