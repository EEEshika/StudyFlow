<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Auth/login.php");
    exit();
}

require_once "../../Config/database.php";
require_once "../../Models/Task.php";

$task = new Task($conn);

$totalTasks = $task->getTotalTasks($_SESSION['user_id']);
$completedTasks = $task->getCompletedTasks($_SESSION['user_id']);
$pendingTasks = $task->getPendingTasks($_SESSION['user_id']);
$overdueTasks = $task->getOverdueTasks($_SESSION['user_id']);

include "../../Includes/header.php";

?>

<div class="dashboard">

<?php include "../../Includes/sidebar.php"; ?>

<div class="dashboard-main">

<h1>
Welcome,
<?= htmlspecialchars($_SESSION['user_name']); ?> 👋
</h1>

<p>
Let's make today productive.
</p>

<div class="dashboard-cards">

<div class="dashboard-card">

<h3>Total Tasks</h3>

<h1><?= $totalTasks; ?></h1>

</div>

<div class="dashboard-card">

<h3>Completed</h3>

<h1><?= $completedTasks; ?></h1>

</div>

<div class="dashboard-card">

<h3>Pending</h3>

<h1><?= $pendingTasks; ?></h1>

</div>

<div class="dashboard-card">

<h3>Overdue</h3>

<h1><?= $overdueTasks; ?></h1>

</div>

</div>

</div>

</div>

<?php include "../../Includes/footer.php"; ?>