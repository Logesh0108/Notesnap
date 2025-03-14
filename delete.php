<?php
session_start();
include 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$note_id = $conn->real_escape_string($_GET['id']);

// Delete the note from the database
$sql = "DELETE FROM notes WHERE id = '$note_id' AND user_id = '" . $_SESSION['user_id'] . "'";
$delete_successful = $conn->query($sql);

// Redirect to view.php with the appropriate status
if ($delete_successful) {
    header('Location: view.php?status=delete_success');
    exit();  // Ensure the script stops after the redirect
} else {
    header('Location: alter.php?id=' . $note_id . '&status=error');
    exit();
}
