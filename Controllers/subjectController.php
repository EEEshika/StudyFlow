<?php

session_start();

require_once __DIR__ . "/../Config/database.php";
require_once __DIR__ . "/../Models/Subject.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Views/Auth/login.php");
    exit();
}

$subject = new Subject($conn);
$user_id = $_SESSION['user_id'];

/* ===========================
   Add Subject
=========================== */

if (isset($_POST['addSubject'])) {

    $subject_name = trim($_POST['subject_name']);
    $subject_code = trim($_POST['subject_code']);
    $instructor = trim($_POST['instructor']);

    if (empty($subject_name)) {

        $_SESSION['subject_error'] = "Subject name is required.";

        header("Location: ../Views/Subject/add.php");

        exit();
    }

    $result = $subject->addSubject(
        $user_id,
        $subject_name,
        $subject_code,
        $instructor
    );

    if ($result) {

        $_SESSION['subject_success'] = "Subject added successfully.";

    } else {

        $_SESSION['subject_error'] = "Failed to add subject.";

    }

    header("Location: ../Views/Subject/list.php");

    exit();
}

/* ===========================
   Update Subject
=========================== */

if (isset($_POST['updateSubject'])) {

    $id = (int)$_POST['subject_id'];

    $subject_name = trim($_POST['subject_name']);
    $subject_code = trim($_POST['subject_code']);
    $instructor = trim($_POST['instructor']);

    $result = $subject->updateSubject(
        $id,
        $user_id,
        $subject_name,
        $subject_code,
        $instructor
    );

    if ($result) {

        $_SESSION['subject_success'] = "Subject updated successfully.";

    } else {

        $_SESSION['subject_error'] = "Failed to update subject.";

    }

    header("Location: ../Views/Subject/list.php");

    exit();
}

/* ===========================
   Delete Subject
=========================== */

if (isset($_GET['action']) && $_GET['action'] == "delete") {

    $id = (int)$_GET['id'];

    if ($subject->deleteSubject($id, $user_id)) {

        $_SESSION['subject_success'] = "Subject deleted successfully.";

    } else {

        $_SESSION['subject_error'] = "Failed to delete subject.";

    }

    header("Location: ../Views/Subject/list.php");

    exit();
}