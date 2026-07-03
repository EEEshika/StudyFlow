<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Auth/login.php");
    exit();
}

require_once "../../Config/database.php";
require_once "../../Models/Task.php";
require_once "../../Models/Subject.php";
require_once "../../Models/StudySession.php";
require_once "../../Models/Note.php";

$task = new Task($conn);
$subject = new Subject($conn);
$study = new StudySession($conn);
$note = new Note($conn);

$user_id = $_SESSION['user_id'];

// Task Statistics
$totalTasks = $task->getTotalTasks($user_id);
$completedTasks = $task->getCompletedTasks($user_id);
$pendingTasks = $task->getPendingTasks($user_id);
$overdueTasks = $task->getOverdueTasks($user_id);

// Subject Statistics
$totalSubjects = $subject->getTotalSubjects($user_id);

// Note Statistics
$totalNotes = $note->getTotalNotes($user_id);

// Study Statistics
$totalStudyMinutes = $study->getTotalStudyMinutes($user_id);
$totalStudyHours = round($totalStudyMinutes / 60, 1);

// Recent Data

$recentTasks = $task->getRecentTasks($user_id);

$recentNotes = $note->getRecentNotes($user_id);

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

        <!-- Row 1 -->

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

        <!-- Row 2 -->

        <div class="dashboard-cards">

            <div class="dashboard-card">

                <h3>Total Subjects</h3>

                <h1><?= $totalSubjects; ?></h1>

            </div>

            <div class="dashboard-card">

                <h3>Total Notes</h3>

                <h1><?= $totalNotes; ?></h1>

            </div>

            <div class="dashboard-card">

                <h3>Study Hours</h3>

                <h1><?= $totalStudyHours; ?></h1>

            </div>

            <div class="dashboard-card">

                <h3>Study Minutes</h3>

                <h1><?= $totalStudyMinutes; ?></h1>

            </div>

                </div>

        <!-- ===========================
        Recent Activity
        =========================== -->

        <div class="dashboard-row">

    <!-- Recent Tasks -->

    <div class="dashboard-box">

        <h2>Recent Tasks</h2>

        <table class="dashboard-table">

            <thead>

                <tr>

                    <th>Task</th>

                    <th>Priority</th>

                    <th>Due Date</th>

                </tr>

            </thead>

            <tbody>

            <?php if($recentTasks->num_rows > 0): ?>

                <?php while($row = $recentTasks->fetch_assoc()): ?>

                    <tr>

                        <td>

                            <?= htmlspecialchars($row['title']); ?>

                        </td>

                        <td>

                            <?= htmlspecialchars($row['priority']); ?>

                        </td>

                        <td>

                            <?= htmlspecialchars($row['due_date']); ?>

                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>

                    <td colspan="3">

                        No recent tasks found.

                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>


        <!-- Recent Notes -->

    <div class="dashboard-box">

        <h2>Recent Notes</h2>

        <table class="dashboard-table">

            <thead>

                <tr>

                    <th>Title</th>

                    <th>Created</th>

                </tr>

            </thead>

            <tbody>

            <?php if($recentNotes->num_rows > 0): ?>

                <?php while($row = $recentNotes->fetch_assoc()): ?>

                    <tr>

                        <td>

                            <?= htmlspecialchars($row['title']); ?>

                        </td>

                        <td>

                            <?= date("d M Y", strtotime($row['created_at'])); ?>

                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>

                    <td colspan="2">

                        No recent notes found.

                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

    </div>

</div>

</div>

<?php include "../../Includes/footer.php"; ?>