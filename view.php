<?php
session_start();

include 'config.php';

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit(); // Ensures script stops execution
}

$user_id = $conn->real_escape_string($_SESSION['user_id']);
$login_time = $_SESSION['login_time'] ?? '1970-01-01 00:00:00'; // Default value if session is missing

// Get the user's first name
$sql = "SELECT first_name FROM registered WHERE id = '$user_id'";
$result = $conn->query($sql);

$first_name = ($result->num_rows === 1) ? htmlspecialchars($result->fetch_assoc()['first_name']) : "Guest";

// Get notes created during the session
$sql = "SELECT id, title, description, created_at FROM notes WHERE user_id = '$user_id' AND created_at >= '$login_time' ORDER BY created_at DESC";
$notes_result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Notes - NoteSnap</title>
    <link rel="icon" type="image/png" href="src/eye.png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body, html {
            font-family: Arial, sans-serif;
            height: 100%;
            overflow: hidden;
        }
        .navbar {
            background-color: #043927;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar-brand {
            color: white !important;
        }
        .navbar-nav li a {
            font-weight: bolder;
            color: wheat !important;
            border-radius: 10px;
        }
        .navbar-nav li a:hover {
            background-color: white;
            color: black !important;
        }
        .username {
            text-align: center;
            font-size: 1.5rem;
            margin: 20px 0;
            color: rgb(105, 67, 10);
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
            animation: slideIn 1s forwards;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-200%); }
            to { opacity: 1; transform: translateX(0); }
        }
        .notes-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            padding: 1rem;
            height: calc(100vh - 60px);
            overflow-y: auto;
        }
        .note-card {
            background-color: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.66);
            text-align: center;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }
        .note-card:hover {
            transform: translateY(-5px);
        }
        .note-card h3, .note-card p {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .note-card:hover::after {
            content: "Click to edit";
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.9rem;
        }
        .datafound {
            text-align: center;
            font-size: 1.5rem;
            color: rgb(203, 0, 0);
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#">Note Snap</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="create.php">Create Notes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
        <!-- Search Bar with Dropdown -->
        <form class="form-inline my-2 my-lg-0">
            <div class="input-group">
                <div class="input-group-prepend">
                    <select class="custom-select" id="searchFilter">
                        <option value="title">Title</option>
                        <option value="content">Content</option>
                        <option value="date">Date</option>
                    </select>
                </div>
                <input class="form-control" type="search" id="searchInput" placeholder="Search..." aria-label="Search">
            </div>
        </form>
    </div>
</nav>

<div class="username">
    Hello, <?php echo $first_name; ?>! You are viewing your saved notes.
</div>

<div class="notes-container">
    <?php if ($notes_result->num_rows > 0): ?>
        <?php while ($note = $notes_result->fetch_assoc()): ?>
            <div class="note-card" onclick="window.location.href='alter.php?id=<?php echo $note['id']; ?>'">
                <h3 class="title"><?php echo htmlspecialchars($note['title']); ?></h3>
                <p class="content"><?php echo nl2br(htmlspecialchars($note['description'])); ?></p>
                <span class="date"><?php echo date('F j, Y, g:i a', strtotime($note['created_at'])); ?></span>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="datafound">No notes found.</p>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById("searchInput").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let criteria = document.getElementById("searchFilter").value;
        let notes = document.querySelectorAll(".note-card");

        notes.forEach(note => {
            let title = note.querySelector(".title").innerText.toLowerCase();
            let content = note.querySelector(".content").innerText.toLowerCase();
            let date = note.querySelector(".date").innerText.toLowerCase();
            
            let match = false;
            if (criteria === "title" && title.includes(filter)) match = true;
            if (criteria === "content" && content.includes(filter)) match = true;
            if (criteria === "date" && date.includes(filter)) match = true;
            
            note.style.display = match ? "block" : "none";
        });
    });
</script>
</body>
</html>
