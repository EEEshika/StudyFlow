<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Auth/login.php");
    exit();
}

require_once "../../Config/database.php";
require_once "../../Models/Subject.php";

$subject = new Subject($conn);

if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit();
}

$data = $subject->getSubjectById(
    (int)$_GET['id'],
    $_SESSION['user_id']
);

if (!$data) {
    header("Location: list.php");
    exit();
}

include "../../Includes/header.php";
include "../../Includes/sidebar.php";

?>

<div class="main">

<div class="task-card">

<h1 class="task-title">Edit Subject</h1>

<form
action="../../Controllers/subjectController.php"
method="POST"
class="task-form">

<input
type="hidden"
name="subject_id"
value="<?= $data['id']; ?>">

<div class="input-group">

<label>Subject Name</label>

<input
type="text"
name="subject_name"
value="<?= htmlspecialchars($data['subject_name']); ?>"
required>

</div>

<div class="input-group">

<label>Subject Code</label>

<input
type="text"
name="subject_code"
value="<?= htmlspecialchars($data['subject_code']); ?>">

</div>

<div class="input-group">

<label>Instructor</label>

<input
type="text"
name="instructor"
value="<?= htmlspecialchars($data['instructor']); ?>">

</div>

<button
type="submit"
name="updateSubject"
class="task-btn">

Update Subject

</button>

</form>

</div>

</div>

<?php include "../../Includes/footer.php"; ?>