<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Auth/login.php");
    exit();
}

require_once "../../Config/database.php";
require_once "../../Models/StudySession.php";

$model = new StudySession($conn);

$list = $model->getAllSessions($_SESSION['user_id']);

include "../../Includes/header.php";
include "../../Includes/sidebar.php";
?>

<div class="main">

<div class="card">

<h2>Study History</h2>

<table>

<tr>

<th>Subject</th>
<th>Start</th>
<th>End</th>
<th>Minutes</th>
<th>Action</th>

</tr>

<?php while($row=$list->fetch_assoc()){ ?>

<tr>

<td><?= htmlspecialchars($row['subject_name']); ?></td>

<td><?= date("d M Y h:i A",strtotime($row['start_time'])); ?></td>

<td>

<?= $row['end_time']
? date("d M Y h:i A",strtotime($row['end_time']))
: "Running"; ?>

</td>

<td>

<?= $row['duration'] ?? 0; ?>

</td>

<td>

<a href="../../Controllers/studySessionController.php?action=delete&id=<?= $row['id']; ?>"
   onclick="return confirm('Are you sure you want to delete this study session?');">
    Delete
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

<?php include "../../Includes/footer.php"; ?>