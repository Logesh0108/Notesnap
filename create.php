<?php
session_start();
include 'config.php';

$success = false; // Track success state

// Check if user is logged in
if (isset($_SESSION['email'])) {
    $email = $conn->real_escape_string($_SESSION['email']);
    $sql = "SELECT first_name FROM registered WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $first_name = htmlspecialchars($row['first_name']);
    } else {
        $first_name = "Guest";
    }
} else {
    $first_name = "Guest";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $user_id = $_SESSION['user_id']; // Fetch user ID from session

    $sql = "INSERT INTO notes (title, description, created_at, user_id, email) 
            VALUES ('$title', '$description', NOW(), '$user_id', '{$_SESSION['email']}')";

    if ($conn->query($sql) === TRUE) {
        $success = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="src/create.png">
    <title>NoteSnap</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    body {
        background-color: rgb(255, 255, 255);
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }
    .navbar {
        background-color: #043927;
        position: sticky;
        top: 0;
        z-index: 1000;
        width: 100%;
        color: white;
    }
    .navbar-brand {
        color: white !important;
    }
    .navbar-nav li a {
        font-weight: bolder;
        color: white !important;
        border-radius: 10px;
    }
    .navbar-nav li a:hover {
        background-color: #ffffff;
        color: #000000 !important;
    }
    
    .username {
    margin-top: 20px;
    text-align: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
    opacity: 0;
    transform: translateX(-100%);
    animation: slideIn 1s forwards;
    color: rgb(105, 67, 10);
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); /* Adds a subtle shadow */
}

    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-200%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .form-container {
        max-width: 500px;
        background: #043927;
        border-radius: 12px;
        padding: 25px;
        box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px;
        text-align: center;
        color: white;
        margin: 80px auto;
    }

    h3 {
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .form-group {
        margin-bottom: 15px;
        text-align: left;
    }

    label {
        font-size: 14px;
        font-weight: 500;
        display: block;
        margin-bottom: 5px;
    }

    input, textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 8px;
        font-size: 14px;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        outline: none;
    }

    input:focus, textarea:focus {
        border-color: #ff9900;
        background: rgb(0, 0, 0);
    }

    .btn-block {
        display: inline-block;
        width: 100%;
        padding: 14px;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        color: white;
        background: #012401;
        box-shadow: 0px 5px 15px rgba(255, 255, 255, 0.3);
        transition: all 0.4s ease-in-out;
    }

    .btn-block:hover {
        transform: translateY(-3px);
        box-shadow: 0px 10px 20px rgba(255, 255, 255, 0.6);
        color: white;
    }

   /* Full-Screen Glass Effect Popup */
.success-popup {
    display: <?php echo $success ? 'flex' : 'none'; ?>;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    align-items: center;
    justify-content: center;
    text-align: center;
    z-index: 1000;
}

/* Popup Content */
.popup-content {
    background: rgba(0, 0, 0, 0.6);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
    color: white;
    width: 90%;
    max-width: 400px;
}

/* Buttons */
.success-popup .btn {
    margin: 10px;
    padding: 12px 20px;
    border-radius: 30px;
    border: none;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s ease-in-out;
}

.success-popup .btn-primary {
    background-color: #28a745;
    color: white;
}

.success-popup .btn-secondary {
    background-color: #007bff;
    color: white;
}

.success-popup .btn:hover {
    transform: translateY(-2px);
    opacity: 0.9;
}


    @media (max-width: 480px) {
        .form-container {
            width: 90%;
            padding: 20px;
        }
    }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#">Note Snap</a>

    <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view.php">View Notes</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" >Logout</a>
                </li>
                
            </ul>
</nav>

<div class="username">Welcome, <?php echo $first_name; ?>!</div>

<div class="form-container">
    <h3>Create a Note</h3>
    <form action="" method="POST">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-block">Save Note</button>
    </form>
</div>

<!-- Success Popup -->
<div class="success-popup">
    <div class="popup-content">
        <h3>Note Saved Successfully!</h3>
        <button class="btn btn-primary" onclick="window.location.href='view.php'">View Notes</button>
        <button class="btn btn-secondary" onclick="window.location.href='create.php'">Create Another</button>
    </div>
</div>


</body>
<script>
    setTimeout(() => {
    document.querySelector('.success-popup').style.display = 'none';
}, 3000); // Hide after 3 seconds
</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</script>
</html>
