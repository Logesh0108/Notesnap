<?php
session_start();
include 'config.php';
require 'src/fpdf186/fpdf.php'; // Ensure this path is correct

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$note_id = $conn->real_escape_string($_GET['id']);
$user_id = $_SESSION['user_id'];

// Fetch the note and username from the database
$sql = "SELECT n.title, n.description, n.created_at, u.first_name 
        FROM notes n 
        JOIN registered u ON n.user_id = u.id 
        WHERE n.id = '$note_id' AND n.user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $note = $result->fetch_assoc();
    $created_at = date('F j, Y', strtotime($note['created_at']));
    $username = htmlspecialchars($note['first_name']); // Get username
} else {
    echo "Note not found or you do not have permission to download this note.";
    exit();
}

// Generate PDF
$pdf = new FPDF();
$pdf->AliasNbPages(); // Enable total page numbers
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

$logoPath = 'src/logo.png'; // Adjust the path to your logo file
$pdf->Image($logoPath, 10, 8, 20); // Adjust x, y, and size as needed

// Title
$pdf->SetXY(10, 10); // Set position    
$pdf->Cell(0, 10, strtoupper($note['title']), 0, 1, 'C');

// Date
$pdf->SetXY(190, 10); // Set position
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'Created on: ' . $created_at, 0, 0, 'R');

// Line below the title
$pdf->SetXY(10, 30); // Set position
$pdf->SetLineWidth(0.5);
$pdf->Line(10, 22, 200, 22); // Draw line from left to right

// Description
$pdf->Ln(15);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, $note['description'], 0, 'J');

// Draw borders
$pdf->SetXY(5, 5); // Set position for border
$pdf->SetLineWidth(0.3);
$pdf->Rect(5, 5, 200, 287); // Draw border around the page

// Output PDF with username in the filename
$filename = 'Snap_' . $username . '_' . $note_id . '.pdf';
$pdf->Output('D', $filename);

// Close the connection
$conn->close();
?>
