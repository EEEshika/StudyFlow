<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Auth/login.php");
    exit();
}

require_once "../../Config/database.php";
require_once "../../Models/Subject.php";
require_once "../../Models/StudySession.php";

$subjectModel = new Subject($conn);
$studyModel = new StudySession($conn);

$subjects = $subjectModel->getAllSubjects($_SESSION['user_id']);
$running = $studyModel->getRunningSession($_SESSION['user_id']);

include "../../Includes/header.php";
include "../../Includes/sidebar.php";
?>

<div class="main">

<div class="task-card">

<h2>Study Session</h2>

<?php
if(isset($_SESSION['study_success'])){
    echo "<p class='success'>".$_SESSION['study_success']."</p>";
    unset($_SESSION['study_success']);
}

if(isset($_SESSION['study_error'])){
    echo "<p class='error'>".$_SESSION['study_error']."</p>";
    unset($_SESSION['study_error']);
}
?>

<?php if(!$running){ ?>

<form action="../../Controllers/studySessionController.php" method="POST">

<div class="input-group">

<label>Select Subject</label>

<select name="subject_id" required>

<option value="">Select Subject</option>

<?php while($row=$subjects->fetch_assoc()){ ?>

<option value="<?= $row['id']; ?>">

<?= htmlspecialchars($row['subject_name']); ?>

</option>

<?php } ?>

</select>

</div>

<button
type="submit"
name="startSession"
class="task-btn">

Start Study

</button>

</form>

<?php } else { ?>

<h3><?= htmlspecialchars($running['subject_name']); ?></h3>

<p>

Started :
<?= date("d M Y h:i A",strtotime($running['start_time'])); ?>

</p>

<br>

<a
class="btn"
href="../../Controllers/studySessionController.php?action=stop&id=<?= $running['id']; ?>">

End Study Session

</a>

<?php } ?>

</div>

</div>

<?php include "../../Includes/footer.php"; ?>