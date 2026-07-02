<?php

session_start();

require_once "../Config/database.php";
require_once "../Models/StudySession.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Views/Auth/login.php");
    exit();
}

$study = new StudySession($conn);
$user_id = $_SESSION['user_id'];

// Start Session
if (isset($_POST['startSession'])) {

    $subject_id = (int)$_POST['subject_id'];

    if (empty($subject_id)) {
        $_SESSION['study_error'] = "Please select a subject.";
        header("Location: ../Views/studySession/start.php");
        exit();
    }

    if ($study->getRunningSession($user_id)) {
        $_SESSION['study_error'] = "A study session is already running.";
        header("Location: ../Views/studySession/start.php");
        exit();
    }

    $study->startSession($user_id, $subject_id);

    $_SESSION['study_success'] = "Study session started.";

    header("Location: ../Views/studySession/start.php");
    exit();
}

// End Session
if (isset($_GET['action']) && $_GET['action'] == "stop") {

    $id = (int)$_GET['id'];

    $study->endSession($id, $user_id);

    $_SESSION['study_success'] = "Study session completed.";

    header("Location: ../Views/studySession/list.php");
    exit();
}

// Delete Session
if (isset($_GET['action']) && $_GET['action'] == "delete") {

    $id = (int)$_GET['id'];

    $study->deleteSession($id, $user_id);

    $_SESSION['study_success'] = "Session deleted.";

    header("Location: ../Views/studySession/list.php");
    exit();
}