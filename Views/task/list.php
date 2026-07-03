<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Auth/login.php");
    exit();
}

require_once "../../Config/database.php";
require_once "../../Models/Task.php";

$taskModel = new Task($conn);

$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$status = isset($_GET['status']) ? trim($_GET['status']) : "";

if ($search != "" || $status != "") {

    $tasks = $taskModel->searchAndFilterTasks(
        $_SESSION['user_id'],
        $search,
        $status
    );

} else {

    $tasks = $taskModel->getAllTasks($_SESSION['user_id']);

}

include "../../Includes/header.php";
include "../../Includes/sidebar.php";

?>

<div class="main">

<div class="card">

<h1>My Tasks</h1>

<?php

if(isset($_SESSION['task_success'])){

    echo "<p class='success'>".$_SESSION['task_success']."</p>";

    unset($_SESSION['task_success']);
}

if(isset($_SESSION['task_error'])){

    echo "<p class='error'>".$_SESSION['task_error']."</p>";

    unset($_SESSION['task_error']);
}

?>

<p style="margin-bottom:20px;">

<a href="add.php" class="btn">

+ Add Task

</a>

</p>

<form method="GET" style="margin-bottom:20px;">

<input
type="text"
name="search"
placeholder="Search Task..."
value="<?= htmlspecialchars($search); ?>">

<select name="status">

<option value="">All Status</option>

<option value="Pending"
<?= $status=="Pending"?"selected":""; ?>>

Pending

</option>

<option value="Completed"
<?= $status=="Completed"?"selected":""; ?>>

Completed

</option>

</select>

<button class="btn">

Search

</button>

</form>

<table>

<tr>

<th>Title</th>

<th>Subject</th>

<th>Category</th>

<th>Priority</th>

<th>Status</th>

<th>Due Date</th>

<th width="180">Action</th>

</tr>

<?php if($tasks->num_rows > 0){ ?>

<?php while($row = $tasks->fetch_assoc()){ ?>

<tr>

<td><?= htmlspecialchars($row['title']); ?></td>

<td><?= htmlspecialchars($row['subject_name'] ?? '-'); ?></td>

<td><?= htmlspecialchars($row['category_name']); ?></td>

<td><?= htmlspecialchars($row['priority']); ?></td>

<td><?= htmlspecialchars($row['status']); ?></td>

<td><?= htmlspecialchars($row['due_date']); ?></td>

<td>

<a href="edit.php?id=<?= $row['id']; ?>">

Edit

</a>

|

<a
href="../../Controllers/taskController.php?action=complete&id=<?= $row['id']; ?>"
onclick="return confirm('Mark as Completed?')">

Complete

</a>

|

<a href="../../Controllers/taskController.php?action=delete&id=<?= $row['id']; ?>"
   onclick="return confirm('Are you sure you want to delete this task?');">
    Delete
</a>

</td>

</tr>

<?php } ?>

<?php } else { ?>

<tr>

<td colspan="7" style="text-align:center;">

No Tasks Found.

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

<?php include "../../Includes/footer.php"; ?>