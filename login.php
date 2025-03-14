<?php
session_start();
include 'config.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Retrieve user details
    $sql = "SELECT id, first_name, last_name, email, password FROM registered WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['first_name'] = htmlspecialchars($row['first_name']);
            $_SESSION['last_name'] = htmlspecialchars($row['last_name']);
            $_SESSION['login_time'] = date('Y-m-d H:i:s'); // Store login time

            // Display alert and redirect to create.php
            echo "<script>
                    alert('Login successful! Redirecting to Creating Note.');
                    window.location.href = 'create.php';
                  </script>";
            exit();
        }
    }

    // If login fails, display alert and redirect to login.php
    echo "<script>
            alert('Login failed! Please check your credentials.');
            window.location.href = 'login.php';
          </script>";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Snap Notes - A web application to quickly save and manage notes with ease.">
<meta name="keywords" content="Snap Notes, Notes App, Web Development, JavaScript, Productivity">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <!-- Bootstrap CSS (can be from CDN or locally) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/png" href="src/loginn.png">
    <title>NoteSnap</title>
    <style>
   /* General Styles */
body {
    font-family: 'Poppins', sans-serif;
    background: white;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    padding: 20px;
}

/* Navbar */
.navbar {
    background-color: #043927;
    width: 100%;
    position: fixed;
    top: 0;
    z-index: 1000;
}

.navbar-brand {
    color: white !important;
}

.navbar-nav li a {
    color: white !important;
    font-weight: bolder;
    border-radius: 10px;
}

.navbar-nav li a:hover {
    background-color: white;
    color: black !important;
}

/* Container */
.container {
    max-width: 400px;
    background: #043927;
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 25px;
    box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px;
    text-align: center;
    color: white;
    margin-top: 80px;
}

h2 {
    margin-bottom: 15px;
    font-size: 24px;
    font-weight: 600;
    text-transform: uppercase;
}

/* Form */
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

input {
    width: 100%;
    padding: 10px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 8px;
    font-size: 14px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    outline: none;
}

input:focus {
    border-color: #043927;
    background: rgb(0, 0, 0);
}

/* Button Styles */
.btn-animated {
    display: inline-block;
    padding: 14px 24px;
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    outline: none;
    color: white;
    background: #012401;
    box-shadow: 0px 5px 15px rgba(255, 255, 255, 0.3);
    transition: all 0.4s ease-in-out;
    position: relative;
    overflow: hidden;
}

/* Hover Effect - 3D Depth & Glow */
.btn-animated:hover {
    transform: translateY(-3px);
    box-shadow: 0px 10px 20px rgba(255, 255, 255, 0.6);
}

/* Active State - Click Effect */
.btn-animated:active {
    transform: scale(0.95);
    box-shadow: 0px 3px 10px rgba(255, 255, 255, 0.4);
}

/* Ripple Effect */
.btn-animated::before {
    content: "";
    position: absolute;
    width: 200%;
    height: 200%;
    top: 50%;
    left: 50%;
    background: rgba(255, 255, 255, 0.3);
    transition: all 0.4s ease-out;
    transform: translate(-50%, -50%) scale(0);
    border-radius: 50%;
}

.btn-animated:active::before {
    transform: translate(-50%, -50%) scale(1);
    opacity: 0;
}

/* Error Message */
.error-message {
    display: none;
    margin-top: 10px;
    padding: 10px;
    background-color: #dc3545;
    color: white;
    border-radius: 5px;
}

/* Responsive */
@media (max-width: 480px) {
    .container {
        width: 90%;
        padding: 20px;
    }
}

.login-link {
    margin-top: 10px;
    font-size: 14px;
    text-align: center;
}

.login-link a {
    color:rgb(255, 255, 255);
    text-decoration: none;
    font-weight: bold;
}

.login-link a:hover {
    color:rgb(193, 171, 0);
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
                    <a class="nav-link" href="register.php" >Register</a>
                </li>
                
            </ul>
        </div>
    </nav>
 


    <div class="container">
    <h2>Login</h2>
    <form id="login-form" method="post" action="login.php">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button class="btn-animated">Login</button>
    </form>

    <br>
    <br>
    <p class="login-link">Don't have an account? <a href="register.php">Register here</a></p>
    <div class="error-message" id="error-message">Invalid email or password!</div>
</div>

 
    
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>
