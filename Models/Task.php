<?php

class Task
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    
    public function addTask($user_id, $category_id, $subject_id, $title, $description, $priority, $due_date)
{
    $sql = "INSERT INTO tasks
            (user_id, category_id, subject_id, title, description, priority, due_date)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->conn->prepare($sql);

    if (!$stmt) {
        die("Prepare Error: " . $this->conn->error);
    }

    $stmt->bind_param(
        "iiissss",
        $user_id,
        $category_id,
        $subject_id,
        $title,
        $description,
        $priority,
        $due_date
    );

    if (!$stmt->execute()) {
        die("Execute Error: " . $stmt->error);
    }

    return true;
}
   
    // Get All Tasks
    public function getAllTasks($user_id)
{
    $sql = "SELECT
                tasks.*,
                categories.category_name,
                subjects.subject_name
            FROM tasks

            LEFT JOIN categories
                ON tasks.category_id = categories.id

            LEFT JOIN subjects
                ON tasks.subject_id = subjects.id

            WHERE tasks.user_id = ?

            ORDER BY tasks.id DESC";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param("i", $user_id);

    $stmt->execute();

    return $stmt->get_result();
}
    // Search Tasks
    public function searchTasks($user_id, $keyword)
    {
        $sql = "SELECT tasks.*, categories.category_name
                FROM tasks
                LEFT JOIN categories
                ON tasks.category_id = categories.id
                WHERE tasks.user_id = ?
                AND tasks.title LIKE ?
                ORDER BY tasks.id DESC";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare Failed : " . $this->conn->error);
        }

        $search = "%" . $keyword . "%";

        $stmt->bind_param("is", $user_id, $search);
        $stmt->execute();

        return $stmt->get_result();
    }

   public function searchAndFilterTasks($user_id, $keyword = '', $status = '')
{
    $sql = "SELECT
                tasks.*,
                categories.category_name,
                subjects.subject_name
            FROM tasks

            LEFT JOIN categories
                ON tasks.category_id = categories.id

            LEFT JOIN subjects
                ON tasks.subject_id = subjects.id

            WHERE tasks.user_id = ?";

    $types = "i";
    $params = [$user_id];

    if (!empty($keyword)) {
        $sql .= " AND tasks.title LIKE ?";
        $types .= "s";
        $params[] = "%" . $keyword . "%";
    }

    if (!empty($status)) {
        $sql .= " AND tasks.status = ?";
        $types .= "s";
        $params[] = $status;
    }

    $sql .= " ORDER BY tasks.id DESC";

    $stmt = $this->conn->prepare($sql);

    if (!$stmt) {
        die($this->conn->error);
    }

    $stmt->bind_param($types, ...$params);

    $stmt->execute();

    return $stmt->get_result();
}

    // Delete Task
    public function deleteTask($id, $user_id)
    {
        $sql = "DELETE FROM tasks
                WHERE id = ?
                AND user_id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare Failed : " . $this->conn->error);
        }

        $stmt->bind_param("ii", $id, $user_id);

        return $stmt->execute();
    }

    // Mark Complete
    public function markComplete($id, $user_id)
    {
        $sql = "UPDATE tasks
                SET status = 'Completed',
                    completed_at = NOW()
                WHERE id = ?
                AND user_id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare Failed : " . $this->conn->error);
        }

        $stmt->bind_param("ii", $id, $user_id);

        return $stmt->execute();
    }

    // Total Tasks
    public function getTotalTasks($user_id)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM tasks
                WHERE user_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc()['total'];
    }

    // Pending Tasks
    public function getPendingTasks($user_id)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM tasks
                WHERE user_id = ?
                AND status = 'Pending'";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc()['total'];
    }

    // Completed Tasks
    public function getCompletedTasks($user_id)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM tasks
                WHERE user_id = ?
                AND status = 'Completed'";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc()['total'];
    }

    // Overdue Tasks
    public function getOverdueTasks($user_id)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM tasks
                WHERE user_id = ?
                AND due_date < CURDATE()
                AND status = 'Pending'";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc()['total'];
    }



    public function getTaskById($id, $user_id)
{
    $sql = "SELECT *
            FROM tasks
            WHERE id = ?
            AND user_id = ?";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param("ii", $id, $user_id);

    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}


public function updateTask(
    $id,
    $user_id,
    $category_id,
    $subject_id,
    $title,
    $description,
    $priority,
    $due_date
)
{
    $sql = "UPDATE tasks
            SET
                category_id = ?,
                subject_id = ?,
                title = ?,
                description = ?,
                priority = ?,
                due_date = ?
            WHERE id = ?
            AND user_id = ?";

    $stmt = $this->conn->prepare($sql);

    if (!$stmt) {
        die("Prepare Error: " . $this->conn->error);
    }

    $stmt->bind_param(
        "iissssii",
        $category_id,
        $subject_id,
        $title,
        $description,
        $priority,
        $due_date,
        $id,
        $user_id
    );

    if (!$stmt->execute()) {
        die("Execute Error: " . $stmt->error);
    }

    return true;
}


public function getRecentTasks($user_id)
{
    $sql = "SELECT
                title,
                priority,
                due_date
            FROM tasks
            WHERE user_id=?
            ORDER BY id DESC
            LIMIT 5";

    $stmt = $this->conn->prepare($sql);

    if(!$stmt){
        die($this->conn->error);
    }

    $stmt->bind_param("i",$user_id);

    $stmt->execute();

    return $stmt->get_result();
}
}