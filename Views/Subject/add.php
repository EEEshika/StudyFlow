<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Auth/login.php");
    exit();
}

include "../../Includes/header.php";
include "../../Includes/sidebar.php";

?>

<div class="main">

<div class="task-card">

<h1 class="task-title">Add Subject</h1>

<?php

if(isset($_SESSION['subject_error'])){

    echo "<p class='error'>".$_SESSION['subject_error']."</p>";

    unset($_SESSION['subject_error']);
}

?>

<form
action="../../Controllers/subjectController.php"
method="POST"
class="task-form">

<div class="input-group">

<label>Subject Name</label>

<input
type="text"
name="subject_name"
required>

</div>

<div class="input-group">

<label>Subject Code</label>

<input
type="text"
name="subject_code"
placeholder="Example: CSE101">

</div>

<div class="input-group">

<label>Instructor</label>

<input
type="text"
name="instructor"
placeholder="Example: John Smith">

</div>

<button
type="submit"
name="addSubject"
class="task-btn">

Save Subject

</button>

</form>

</div>

</div>

<?php include "../../Includes/footer.php"; ?>