<?php

class Subject
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Add Subject
    public function addSubject($user_id, $subject_name, $subject_code, $instructor)
    {
        $sql = "INSERT INTO subjects
                (user_id, subject_name, subject_code, instructor)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare Failed: " . $this->conn->error);
        }

        $stmt->bind_param(
            "isss",
            $user_id,
            $subject_name,
            $subject_code,
            $instructor
        );

        return $stmt->execute();
    }

    // Get All Subjects
    public function getAllSubjects($user_id)
    {
        $sql = "SELECT *
                FROM subjects
                WHERE user_id = ?
                ORDER BY subject_name ASC";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare Failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        return $stmt->get_result();
    }

    // Get Single Subject
    public function getSubjectById($id, $user_id)
    {
        $sql = "SELECT *
                FROM subjects
                WHERE id = ?
                AND user_id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare Failed: " . $this->conn->error);
        }

        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // Update Subject
    public function updateSubject($id, $user_id, $subject_name, $subject_code, $instructor)
    {
        $sql = "UPDATE subjects
                SET
                    subject_name = ?,
                    subject_code = ?,
                    instructor = ?
                WHERE id = ?
                AND user_id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare Failed: " . $this->conn->error);
        }

        $stmt->bind_param(
            "sssii",
            $subject_name,
            $subject_code,
            $instructor,
            $id,
            $user_id
        );

        return $stmt->execute();
    }

    // Delete Subject
    public function deleteSubject($id, $user_id)
    {
        $sql = "DELETE FROM subjects
                WHERE id = ?
                AND user_id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare Failed: " . $this->conn->error);
        }

        $stmt->bind_param("ii", $id, $user_id);

        return $stmt->execute();
    }
}