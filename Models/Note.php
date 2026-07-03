<?php

class Note
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Add Note
    public function addNote($user_id, $subject_id, $title, $content)
    {
        $sql = "INSERT INTO user_notes
                (user_id, subject_id, title, content)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare Error: " . $this->conn->error);
        }

        $stmt->bind_param(
            "iiss",
            $user_id,
            $subject_id,
            $title,
            $content
        );

        return $stmt->execute();
    }

    // Get All Notes
    public function getAllNotes($user_id)
    {
        $sql = "SELECT
                    user_notes.*,
                    subjects.subject_name

                FROM user_notes

                LEFT JOIN subjects
                ON user_notes.subject_id = subjects.id

                WHERE user_notes.user_id = ?

                ORDER BY user_notes.id DESC";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare Error: " . $this->conn->error);
        }

        $stmt->bind_param("i", $user_id);

        $stmt->execute();

        return $stmt->get_result();
    }

    // Get Single Note
    public function getNoteById($id, $user_id)
    {
        $sql = "SELECT *
                FROM user_notes
                WHERE id = ?
                AND user_id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare Error: " . $this->conn->error);
        }

        $stmt->bind_param("ii", $id, $user_id);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // Update Note
    public function updateNote(
        $id,
        $user_id,
        $subject_id,
        $title,
        $content
    )
    {
        $sql = "UPDATE user_notes
                SET
                    subject_id = ?,
                    title = ?,
                    content = ?
                WHERE id = ?
                AND user_id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare Error: " . $this->conn->error);
        }

        $stmt->bind_param(
            "issii",
            $subject_id,
            $title,
            $content,
            $id,
            $user_id
        );

        return $stmt->execute();
    }

    // Delete Note
    public function deleteNote($id, $user_id)
    {
        $sql = "DELETE
                FROM user_notes
                WHERE id = ?
                AND user_id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare Error: " . $this->conn->error);
        }

        $stmt->bind_param("ii", $id, $user_id);

        return $stmt->execute();
    }

    // Search Notes
    public function searchNotes($user_id, $keyword = "")
    {
        $sql = "SELECT
                    user_notes.*,
                    subjects.subject_name

                FROM user_notes

                LEFT JOIN subjects
                ON user_notes.subject_id = subjects.id

                WHERE user_notes.user_id = ?";

        $types = "i";
        $params = [$user_id];

        if (!empty($keyword)) {

            $sql .= " AND
                     (
                        user_notes.title LIKE ?
                        OR
                        user_notes.content LIKE ?
                     )";

            $types .= "ss";

            $search = "%" . $keyword . "%";

            $params[] = $search;
            $params[] = $search;
        }

        $sql .= " ORDER BY user_notes.id DESC";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare Error: " . $this->conn->error);
        }

        $stmt->bind_param($types, ...$params);

        $stmt->execute();

        return $stmt->get_result();
    }

    // Total Notes
    public function getTotalNotes($user_id)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM user_notes
                WHERE user_id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare Error: " . $this->conn->error);
        }

        $stmt->bind_param("i", $user_id);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc()['total'];
    }


    public function getRecentNotes($user_id)
{
    $sql="SELECT
            title,
            created_at
          FROM user_notes
          WHERE user_id=?
          ORDER BY id DESC
          LIMIT 5";

    $stmt=$this->conn->prepare($sql);

    if(!$stmt){
        die($this->conn->error);
    }

    $stmt->bind_param("i",$user_id);

    $stmt->execute();

    return $stmt->get_result();
}
}