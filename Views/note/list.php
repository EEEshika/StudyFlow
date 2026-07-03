<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Auth/login.php");
    exit();
}

require_once "../../Config/database.php";
require_once "../../Models/Note.php";

$noteModel = new Note($conn);

if (isset($_GET['search'])) {

    $keyword = trim($_GET['search']);

    $notes = $noteModel->searchNotes(
        $_SESSION['user_id'],
        $keyword
    );

} else {

    $notes = $noteModel->getAllNotes(
        $_SESSION['user_id']
    );

}

include "../../Includes/header.php";
include "../../Includes/sidebar.php";

?>

<div class="main">

<div class="card">

<h1>My Notes</h1>

<?php

if(isset($_SESSION['note_success'])){

    echo "<p class='success'>".$_SESSION['note_success']."</p>";

    unset($_SESSION['note_success']);
}

if(isset($_SESSION['note_error'])){

    echo "<p class='error'>".$_SESSION['note_error']."</p>";

    unset($_SESSION['note_error']);
}

?>

<p style="margin-bottom:20px;">

<a href="add.php" class="btn">

+ Add Note

</a>

</p>

<form
method="GET"
style="margin-bottom:20px;">

<input
type="text"
name="search"
placeholder="Search Note..."
value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

<button
type="submit"
class="btn">

Search

</button>

</form>

<table>

<tr>

<th>Subject</th>

<th>Title</th>

<th>Content</th>

<th>Created</th>

<th width="180">

Action

</th>

</tr>

<?php if($notes->num_rows > 0){ ?>

<?php while($row = $notes->fetch_assoc()){ ?>

<tr>

<td>

<?= htmlspecialchars($row['subject_name']); ?>

</td>

<td>

<?= htmlspecialchars($row['title']); ?>

</td>

<td>

<?= htmlspecialchars(substr($row['content'],0,80)); ?>

<?php if(strlen($row['content'])>80){ ?>

...

<?php } ?>

</td>

<td>

<?= date("d M Y",strtotime($row['created_at'])); ?>

</td>

<td>

<a href="edit.php?id=<?= $row['id']; ?>">

Edit

</a>

|

<a href="../../Controllers/noteController.php?action=delete&id=<?= $row['id']; ?>"
   onclick="return confirm('Are you sure you want to delete this note?');">
    Delete
</a>

</td>

</tr>

<?php } ?>

<?php } else { ?>

<tr>

<td colspan="5" style="text-align:center;">

No notes found.

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

<?php include "../../Includes/footer.php"; ?>