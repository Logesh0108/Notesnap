<?php
session_start();
include 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$note_id = $conn->real_escape_string($_GET['id']);

// Fetch the note from the database
$sql = "SELECT title, description FROM notes WHERE id = '$note_id' AND user_id = '" . $_SESSION['user_id'] . "'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $note = $result->fetch_assoc();
} else {
    echo "Note not found or you do not have permission to edit this note.";
    exit();
}

$first_name = $_SESSION['first_name']; // Get the user's first name

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="src/update.png">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Edit Note - NoteSnap</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            height: 100%;
            background-color: #f9f9f9;
        }
        .navbar{
        background-color:#043927;
    position: sticky;
    top: 0;
    z-index: 1000; /* Ensures the navbar stays above other elements */
    width: 100%; /* Ensures the navbar takes the full width */
    color: #fff; /* White text color */
    }
    .navbar-brand{
        color:rgb(255, 255, 255) !important;
    }
    .navbar-nav li a {
        color: black !important;
        font-weight: bolder;
        color: wheat !important;
        gap: 10px;
        border-radius: 10px;
    }
    .navbar-nav li a:hover{
        background-color: #ffffff ;
        color: #000000 !important;
        border: #ff9900 !important;
    }
    .username {
    margin-top: 20px;
    text-align: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
    opacity: 0;
    transform: translateX(-100%);
    animation: slideIn 1s forwards;
    color: rgb(255, 153, 0);
    text-shadow: 2px 2px 5px rgba(145, 145, 145, 0.5); /* Adds a subtle shadow */
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
    
        .container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 1rem;
            background: #043927;
            color:white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            margin-bottom: 1.5rem;
            text-align:center;
        }

        form {
    max-width: 500px;
    margin: 30px auto;
    padding: 20px;
    background:  #043927;;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(255, 255, 255, 0.59);
    font-family: 'Arial', sans-serif;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: white;
}

input[type="text"], 
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    transition: border 0.3s;
}

input[type="text"]:focus, 
textarea:focus {
    border-color: #007bff;
    outline: none;
}

textarea {
    resize: vertical;
    min-height: 120px;
}

.buttons-container {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

button {
    flex: 1;
    padding: 10px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 0 5px;
}

.update-button {
    background-color: #28a745;
    color: white;
}

.update-button:hover {
    background-color: #218838;
}

.delete-button {
    background-color: #dc3545;
    color: white;
}

.delete-button:hover {
    background-color: #c82333;
}

.download-button {
    background-color: #007bff;
    color: white;
}

.download-button:hover {
    background-color: #0056b3;
}

@media (max-width: 500px) {
    .buttons-container {
        flex-direction: column;
    }
    button {
        margin: 5px 0;
    }
}

        /* Message styles */
        .message {
            position: fixed;
            top: 60px;
            right: 10px;
            background-color: #12372a;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 1001;
            display: none;
        }

        .message.success {
            background-color: #2ecc71;
        }

        .message.error {
            background-color: #e74c3c;
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
                    <a class="nav-link" href="view.php" >View Notes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" >Logout</a>
                </li>
              
            </ul>
        </div>
    </nav>

    <div class="container">
       
        <p class="username">Welcome, <?php echo $first_name; ?>!</p>

        <h2>Edit Your Snap</h2>

        <?php if (isset($_GET['status'])): ?>
<div class="message <?php echo $_GET['status'] === 'error' ? 'error' : 'success'; ?>" id="message">
    <?php if ($_GET['status'] === 'update_success'): ?>
        <p>Note updated successfully!</p>
    <?php elseif ($_GET['status'] === 'delete_success'): ?>
        <p>Note deleted successfully!</p>
    <?php elseif ($_GET['status'] === 'download_success'): ?>
        <p>PDF downloaded successfully!</p>
    <?php elseif ($_GET['status'] === 'error'): ?>
        <p>Oops! Something went wrong. Please try again.</p>
    <?php endif; ?>
</div>
<?php else: ?>
<div class="message" id="message"></div>
<?php endif; ?>

        <form method="post" action="update.php">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($note['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($note['description']); ?></textarea>
            </div>
            <input type="hidden" name="id" value="<?php echo $note_id; ?>">
            <div class="buttons-container">
                <button type="submit" class="update-button">Update Snap</button>
                <button type="button" class="delete-button" onclick="deleteNote()">Delete Snap</button>
                <button type="button" class="download-button" onclick="downloadPDF()">Download Snap</button>
            </div>
        </form>
    </div>

    <script>
        // Hamburger menu functionality
        const hamburgerMenu = document.getElementById('hamburger-menu');
        const navLinks = document.getElementById('nav-links');

        hamburgerMenu.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Success/Error message display
        const message = document.getElementById('message');
        if (message) {
            message.style.display = 'block';
            setTimeout(() => {
                message.style.display = 'none';
            }, 3000);
        }

        function deleteNote() {
            if (confirm('Are you sure you want to delete this note?')) {
                window.location.href = 'delete.php?id=<?php echo $note_id; ?>';
            }
        }

        function downloadPDF() {
            // Perform an AJAX request to download the PDF
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'download.php?id=<?php echo $note_id; ?>', true);
            xhr.responseType = 'blob';

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Create a link to download the PDF file
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(xhr.response);
            link.download = '<?php echo $_SESSION['first_name']; ?>_Snap.pdf';
            link.click();

            // Display the success message
            showMessage('Download successful!', 'success');
        } else {
            // Display an error message if the download fails
            showMessage('Download failed! Please try again.', 'error');
        }
    };

    xhr.send();
}

function showMessage(message, type) {
            var messageBox = document.getElementById('message');

            if (messageBox) {
                messageBox.textContent = message;
                messageBox.classList.remove('error', 'success');
                messageBox.classList.add(type);
                messageBox.style.display = 'block';

                setTimeout(function() {
                    messageBox.style.display = 'none';
                }, 3000);
            } else {
                console.error('Element with ID "message" not found.');
            }
        }
    </script>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>
