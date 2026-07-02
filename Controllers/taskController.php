<?php

session_start();

require_once __DIR__ . "/../Config/database.php";
require_once __DIR__ . "/../Models/Task.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Views/Auth/login.php");
    exit();
}

$task = new Task($conn);
$user_id = $_SESSION['user_id'];


// =====================
// Add Task
// =====================

if (isset($_POST['addTask'])) {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $priority = trim($_POST['priority']);

    $category_id = (int)$_POST['category_id'];

    $subject_id = !empty($_POST['subject_id'])
        ? (int)$_POST['subject_id']
        : null;

    $due_date = $_POST['due_date'];

    if (
        empty($title) ||
        empty($priority) ||
        empty($category_id) ||
        empty($due_date)
    ) {

        $_SESSION['task_error'] = "Please fill all required fields.";

        header("Location: ../Views/task/add.php");

        exit();
    }


    

    $result = $task->addTask(
        $user_id,
        $category_id,
        $subject_id,
        $title,
        $description,
        $priority,
        $due_date
    );

    if ($result) {

        $_SESSION['task_success'] = "Task added successfully.";

    } else {

        $_SESSION['task_error'] = "Failed to add task.";

    }

    header("Location: ../Views/task/list.php");

    exit();
}


// =====================
// Delete Task
// =====================

if (isset($_GET['action']) && $_GET['action'] == "delete") {

    $id = (int)$_GET['id'];

    if ($task->deleteTask($id, $user_id)) {

        $_SESSION['task_success'] = "Task deleted successfully.";

    } else {

        $_SESSION['task_error'] = "Unable to delete task.";

    }

    header("Location: ../Views/task/list.php");

    exit();
}


// =====================
// Complete Task
// =====================

if (isset($_GET['action']) && $_GET['action'] == "complete") {

    $id = (int)$_GET['id'];

    if ($task->markComplete($id, $user_id)) {

        $_SESSION['task_success'] = "Task marked as completed.";

    } else {

        $_SESSION['task_error'] = "Unable to update task.";

    }

    header("Location: ../Views/task/list.php");

    exit();
}


// =====================
// Update Task
// =====================

if (isset($_POST['updateTask'])) {

    $id = (int)$_POST['task_id'];

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $priority = trim($_POST['priority']);

    $category_id = (int)$_POST['category_id'];

    $subject_id = !empty($_POST['subject_id'])
        ? (int)$_POST['subject_id']
        : null;

    $due_date = $_POST['due_date'];

    $result = $task->updateTask(
        $id,
        $user_id,
        $category_id,
        $subject_id,
        $title,
        $description,
        $priority,
        $due_date
    );

    if ($result) {

        $_SESSION['task_success'] = "Task updated successfully.";

    } else {

        $_SESSION['task_error'] = "Failed to update task.";

    }

    header("Location: ../Views/task/list.php");

    exit();
}