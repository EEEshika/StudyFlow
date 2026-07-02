<?php

class StudySession
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Start Study Session
    public function startSession($user_id, $subject_id)
    {
        $sql = "INSERT INTO study_sessions
                (user_id, subject_id, start_time)
                VALUES (?, ?, NOW())";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare Error: " . $this->conn->error);
        }

        $stmt->bind_param("ii", $user_id, $subject_id);

        return $stmt->execute();
    }

    // Get Running Session
    public function getRunningSession($user_id)
    {
        $sql = "SELECT
                    study_sessions.*,
                    subjects.subject_name
                FROM study_sessions

                LEFT JOIN subjects
                ON study_sessions.subject_id = subjects.id

                WHERE study_sessions.user_id = ?
                AND study_sessions.end_time IS NULL

                ORDER BY study_sessions.id DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
    die("Prepare Error: " . $this->conn->error);
}

        $stmt->bind_param("i", $user_id);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // End Session
    public function endSession($id, $user_id)
    {
        $sql = "UPDATE study_sessions

                SET
                    end_time = NOW(),
                    duration = TIMESTAMPDIFF(
                        MINUTE,
                        start_time,
                        NOW()
                    )

                WHERE id = ?
                AND user_id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("ii", $id, $user_id);

        return $stmt->execute();
    }

    // Session History
    public function getAllSessions($user_id)
    {
        $sql = "SELECT
                    study_sessions.*,
                    subjects.subject_name

                FROM study_sessions

                LEFT JOIN subjects
                ON study_sessions.subject_id = subjects.id

                WHERE study_sessions.user_id = ?

                ORDER BY study_sessions.id DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $user_id);

        $stmt->execute();

        return $stmt->get_result();
    }

    // Total Study Minutes
    public function getTotalStudyMinutes($user_id)
    {
        $sql = "SELECT
                    IFNULL(SUM(duration),0) total
                FROM study_sessions
                WHERE user_id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $user_id);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc()['total'];
    }

    // Delete Session
    public function deleteSession($id, $user_id)
    {
        $sql = "DELETE
                FROM study_sessions
                WHERE id=?
                AND user_id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("ii", $id, $user_id);

        return $stmt->execute();
    }
}