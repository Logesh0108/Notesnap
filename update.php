<?php
session_start();
include 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$note_id = $conn->real_escape_string($_POST['id']);
$title = $conn->real_escape_string($_POST['title']);
$description = $conn->real_escape_string($_POST['description']);

// Update the note in the database
$sql = "UPDATE notes SET title = '$title', description = '$description' WHERE id = '$note_id' AND user_id = '" . $_SESSION['user_id'] . "'";
$update_successful = $conn->query($sql);

// JavaScript alert based on success or failure
if ($update_successful) {
    echo "<script>
        alert('Note updated successfully!');
        window.location.href = 'alter.php?id=$note_id';
    </script>";
} else {
    echo "<script>
        alert('Error updating note. Please try again.');
        window.location.href = 'alter.php?id=$note_id';
    </script>";
}
exit();
?>
