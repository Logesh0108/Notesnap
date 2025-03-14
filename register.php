<?php
include 'config.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $conn->real_escape_string($_POST['first-name']);
    $lastName = $conn->real_escape_string($_POST['last-name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password for security

    // Insert data into the database
    $sql = "INSERT INTO registered (first_name, last_name, email, password) 
            VALUES ('$firstName', '$lastName', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Registration successful!');
                window.location.href = 'login.php';
              </script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="src/register.png">
    <title>Register | Note Snap</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
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
            border-color:#043927;
            background: rgb(0, 0, 0);
        }

       /* General Button Styles */
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

        /* Success Message */
        .success-message {
            display: none;
            margin-top: 10px;
            padding: 10px;
            background-color: #28a745;
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

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#">Note Snap</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            
        </ul>
    </div>
</nav>

<!-- Registration Form -->
<div class="container">
    <h2>Register</h2>
    <form id="registration-form" method="post" action="register.php">
        <div class="form-group">
            <label for="first-name">First Name</label>
            <input type="text" id="first-name" name="first-name" required>
        </div>
        <div class="form-group">
            <label for="last-name">Last Name</label>
            <input type="text" id="last-name" name="last-name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button class="btn-animated">Register</button>
    </form><br>
    <br>
    <p class="login-link">Already registered? <a href="login.php">Login here</a></p>
    <div class="success-message" id="success-message">Registration Successful! Redirecting to login...</div>
</div>


<!-- JavaScript -->


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
