<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Auth/login.php");
    exit();
}

require_once "../../Config/database.php";
require_once "../../Models/Subject.php";

$subject = new Subject($conn);

$subjects = $subject->getAllSubjects($_SESSION['user_id']);

include "../../Includes/header.php";
include "../../Includes/sidebar.php";

?>

<div class="main">

<div class="card">

<h1>My Subjects</h1>

<?php

if(isset($_SESSION['subject_success'])){

    echo "<p class='success'>".$_SESSION['subject_success']."</p>";

    unset($_SESSION['subject_success']);
}

if(isset($_SESSION['subject_error'])){

    echo "<p class='error'>".$_SESSION['subject_error']."</p>";

    unset($_SESSION['subject_error']);
}

?>

<p style="margin-bottom:20px;">

<a href="add.php" class="btn">

+ Add Subject

</a>

</p>

<table>

<tr>

<th>Subject Name</th>

<th>Code</th>

<th>Instructor</th>

<th>Created</th>

<th width="180">Action</th>

</tr>

<?php if($subjects->num_rows > 0){ ?>

<?php while($row = $subjects->fetch_assoc()){ ?>

<tr>

<td><?= htmlspecialchars($row['subject_name']) ?></td>

<td><?= htmlspecialchars($row['subject_code']) ?></td>

<td><?= htmlspecialchars($row['instructor']) ?></td>

<td><?= date("d M Y",strtotime($row['created_at'])) ?></td>

<td>

<a href="edit.php?id=<?= $row['id'] ?>">

Edit

</a>

|

<a
href="../../Controllers/subjectController.php?action=delete&id=<?= $row['id'] ?>"
onclick="return confirm('Delete this subject?')">

Delete

</a>

</td>

</tr>

<?php } ?>

<?php } else { ?>

<tr>

<td colspan="5" style="text-align:center;">

No subjects found.

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

<?php include "../../Includes/footer.php"; ?>