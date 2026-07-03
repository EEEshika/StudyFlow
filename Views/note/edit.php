<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Auth/login.php");
    exit();
}

require_once "../../Config/database.php";
require_once "../../Models/Note.php";
require_once "../../Models/Subject.php";

$noteModel = new Note($conn);
$subjectModel = new Subject($conn);

if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit();
}

$id = (int)$_GET['id'];

$note = $noteModel->getNoteById(
    $id,
    $_SESSION['user_id']
);

if (!$note) {
    header("Location: list.php");
    exit();
}

$subjects = $subjectModel->getAllSubjects(
    $_SESSION['user_id']
);

include "../../Includes/header.php";
include "../../Includes/sidebar.php";

?>

<div class="main">

<div class="task-card">

<h1 class="task-title">

Edit Note

</h1>

<form
action="../../Controllers/noteController.php"
method="POST"
class="task-form">

<input
type="hidden"
name="note_id"
value="<?= $note['id']; ?>">

<div class="input-group">

<label>

Subject

</label>

<select
name="subject_id"
required>

<?php while($subject = $subjects->fetch_assoc()){ ?>

<option
value="<?= $subject['id']; ?>"
<?= $note['subject_id']==$subject['id']
? "selected"
: ""; ?>>

<?= htmlspecialchars($subject['subject_name']); ?>

</option>

<?php } ?>

</select>

</div>

<div class="input-group">

<label>

Title

</label>

<input
type="text"
name="title"
value="<?= htmlspecialchars($note['title']); ?>"
required>

</div>

<div class="input-group">

<label>

Content

</label>

<textarea
name="content"
rows="12"
required><?= htmlspecialchars($note['content']); ?></textarea>

</div>

<button
type="submit"
name="updateNote"
class="task-btn">

Update Note

</button>

</form>

</div>

</div>

<?php include "../../Includes/footer.php"; ?>