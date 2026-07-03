<?php

session_start();

require_once __DIR__ . "/../Config/database.php";
require_once __DIR__ . "/../Models/Note.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Views/Auth/login.php");
    exit();
}

$note = new Note($conn);
$user_id = $_SESSION['user_id'];


// ======================
// Add Note
// ======================

if (isset($_POST['addNote'])) {

    $subject_id = (int)$_POST['subject_id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (
        empty($subject_id) ||
        empty($title) ||
        empty($content)
    ) {

        $_SESSION['note_error'] = "Please fill all required fields.";

        header("Location: ../Views/note/add.php");

        exit();
    }

    $result = $note->addNote(
        $user_id,
        $subject_id,
        $title,
        $content
    );

    if ($result) {

        $_SESSION['note_success'] = "Note added successfully.";

    } else {

        $_SESSION['note_error'] = "Failed to add note.";

    }

    header("Location: ../Views/note/list.php");

    exit();
}



// ======================
// Update Note
// ======================

if (isset($_POST['updateNote'])) {

    $id = (int)$_POST['note_id'];

    $subject_id = (int)$_POST['subject_id'];

    $title = trim($_POST['title']);

    $content = trim($_POST['content']);

    $result = $note->updateNote(

        $id,

        $user_id,

        $subject_id,

        $title,

        $content

    );

    if ($result) {

        $_SESSION['note_success'] = "Note updated successfully.";

    } else {

        $_SESSION['note_error'] = "Failed to update note.";

    }

    header("Location: ../Views/note/list.php");

    exit();
}



// ======================
// Delete Note
// ======================

if (isset($_GET['action']) && $_GET['action'] == "delete") {

    $id = (int)$_GET['id'];

    $result = $note->deleteNote($id, $user_id);

    if ($result) {

        $_SESSION['note_success'] = "Note deleted successfully.";

    } else {

        $_SESSION['note_error'] = "Unable to delete note.";

    }

    header("Location: ../Views/note/list.php");

    exit();
}