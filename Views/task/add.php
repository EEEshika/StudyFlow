<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Auth/login.php");
    exit();
}

require_once "../../Config/database.php";
require_once "../../Models/Category.php";
require_once "../../Models/Subject.php";

$categoryModel = new Category($conn);
$subjectModel = new Subject($conn);

$categories = $categoryModel->getAllCategories();
$subjects = $subjectModel->getAllSubjects($_SESSION['user_id']);

include "../../Includes/header.php";
include "../../Includes/sidebar.php";

?>

<div class="main">

    <div class="task-card">

        <h1 class="task-title">Add New Task</h1>

        <?php
        if (isset($_SESSION['task_error'])) {
            echo "<p class='error'>" . $_SESSION['task_error'] . "</p>";
            unset($_SESSION['task_error']);
        }
        ?>

        <form
            action="../../Controllers/taskController.php"
            method="POST"
            class="task-form">

            <div class="input-group">

                <label>Task Title</label>

                <input
                    type="text"
                    name="title"
                    required>

            </div>

            <div class="input-group">

                <label>Description</label>

                <textarea
                    name="description"
                    rows="5"></textarea>

            </div>

            <div class="input-group">

                <label>Subject</label>

                <select name="subject_id">

                    <option value="">Select Subject</option>

                    <?php while ($subject = $subjects->fetch_assoc()) { ?>

                        <option value="<?= $subject['id']; ?>">

                            <?= htmlspecialchars($subject['subject_name']); ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="input-group">

                <label>Category</label>

                <select
                    name="category_id"
                    required>

                    <?php while ($category = $categories->fetch_assoc()) { ?>

                        <option value="<?= $category['id']; ?>">

                            <?= htmlspecialchars($category['category_name']); ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="input-group">

                <label>Priority</label>

                <select name="priority">

                    <option value="Low">Low</option>

                    <option value="Medium" selected>Medium</option>

                    <option value="High">High</option>

                </select>

            </div>

            <div class="input-group">

                <label>Due Date</label>

                <input
                    type="date"
                    name="due_date"
                    required>

            </div>

            <button
                type="submit"
                name="addTask"
                class="task-btn">

                Save Task

            </button>

        </form>

    </div>

</div>

<?php include "../../Includes/footer.php"; ?>