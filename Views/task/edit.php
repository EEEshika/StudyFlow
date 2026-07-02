<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Auth/login.php");
    exit();
}

require_once "../../Config/database.php";
require_once "../../Models/Task.php";
require_once "../../Models/Category.php";
require_once "../../Models/Subject.php";

$taskModel = new Task($conn);
$categoryModel = new Category($conn);
$subjectModel = new Subject($conn);

if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit();
}

$id = (int)$_GET['id'];

$task = $taskModel->getTaskById($id, $_SESSION['user_id']);

if (!$task) {
    header("Location: list.php");
    exit();
}

$categories = $categoryModel->getAllCategories();
$subjects = $subjectModel->getAllSubjects($_SESSION['user_id']);

include "../../Includes/header.php";
include "../../Includes/sidebar.php";

?>

<div class="main">

<div class="task-card">

<h1 class="task-title">Edit Task</h1>

<form
action="../../Controllers/taskController.php"
method="POST"
class="task-form">

<input
type="hidden"
name="task_id"
value="<?= $task['id']; ?>">

<div class="input-group">

<label>Task Title</label>

<input
type="text"
name="title"
value="<?= htmlspecialchars($task['title']); ?>"
required>

</div>

<div class="input-group">

<label>Description</label>

<textarea
name="description"
rows="5"><?= htmlspecialchars($task['description']); ?></textarea>

</div>

<div class="input-group">

<label>Subject</label>

<select name="subject_id">

<option value="">Select Subject</option>

<?php while($subject = $subjects->fetch_assoc()){ ?>

<option
value="<?= $subject['id']; ?>"
<?= ($task['subject_id'] == $subject['id']) ? "selected" : ""; ?>>

<?= htmlspecialchars($subject['subject_name']); ?>

</option>

<?php } ?>

</select>

</div>

<div class="input-group">

<label>Category</label>

<select name="category_id">

<?php while($category = $categories->fetch_assoc()){ ?>

<option
value="<?= $category['id']; ?>"
<?= ($task['category_id'] == $category['id']) ? "selected" : ""; ?>>

<?= htmlspecialchars($category['category_name']); ?>

</option>

<?php } ?>

</select>

</div>

<div class="input-group">

<label>Priority</label>

<select name="priority">

<option value="Low" <?= ($task['priority']=="Low") ? "selected" : ""; ?>>Low</option>

<option value="Medium" <?= ($task['priority']=="Medium") ? "selected" : ""; ?>>Medium</option>

<option value="High" <?= ($task['priority']=="High") ? "selected" : ""; ?>>High</option>

</select>

</div>

<div class="input-group">

<label>Due Date</label>

<input
type="date"
name="due_date"
value="<?= $task['due_date']; ?>"
required>

</div>

<button
type="submit"
name="updateTask"
class="task-btn">

Update Task

</button>

</form>

</div>

</div>

<?php include "../../Includes/footer.php"; ?>