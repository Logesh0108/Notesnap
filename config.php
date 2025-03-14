
<?php
$servername = "localhost"; // Change if your database is hosted remotely
$username = "root"; // Change according to your database credentials
$password = ""; // Default password is empty for XAMPP
$dbname = "notex"; // The database name you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
