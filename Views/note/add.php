<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Auth/login.php");
    exit();
}

require_once "../../Config/database.php";
require_once "../../Models/Subject.php";

$subjectModel = new Subject($conn);

$subjects = $subjectModel->getAllSubjects($_SESSION['user_id']);

include "../../Includes/header.php";
include "../../Includes/sidebar.php";

?>

<div class="main">

<div class="task-card">

<h1 class="task-title">Add New Note</h1>

<?php

if (isset($_SESSION['note_error'])) {

    echo "<p class='error'>" . $_SESSION['note_error'] . "</p>";

    unset($_SESSION['note_error']);
}

?>

<form
action="../../Controllers/noteController.php"
method="POST"
class="task-form">

<div class="input-group">

<label>Subject</label>

<select
name="subject_id"
required>

<option value="">Select Subject</option>

<?php while($subject = $subjects->fetch_assoc()){ ?>

<option value="<?= $subject['id']; ?>">

<?= htmlspecialchars($subject['subject_name']); ?>

</option>

<?php } ?>

</select>

</div>

<div class="input-group">

<label>Note Title</label>

<input
type="text"
name="title"
placeholder="Enter note title"
required>

</div>

<div class="input-group">

<label>Note Content</label>

<textarea
name="content"
rows="10"
placeholder="Write your note here..."
required></textarea>

</div>

<button
type="submit"
name="addNote"
class="task-btn">

Save Note

</button>

</form>

</div>

</div>

<?php include "../../Includes/footer.php"; ?>