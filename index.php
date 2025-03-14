<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteSnap</title>
    <link rel="icon" type="image/png" href="src/logo.png">

    
    <!-- Bootstrap & FontAwesome -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        /* Global Styles */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

/* Navbar */
.navbar {
    background-color: #043927;
    padding: 15px;
}
.navbar {
    position: sticky;
    top: 0;
    z-index: 1000;
    background-color: #043927; /* Your navbar color */
    transition: all 0.3s ease-in-out;
}
.navbar.scrolled {
    background-color: #021f15; /* Darker shade when scrolled */
    box-shadow: 0 4px 8px rgb(0, 0, 0);
}

.navbar-brand, .navbar-nav .nav-link {
    color: white !important;
    font-weight: bold;
}
.navbar-nav .nav-link:hover {
    background-color: white;
    color: #043927 !important;
    border-radius: 5px;
}

/* About Section */
.about {
    text-align: center;
    padding: 50px 20px;
    background-color: #fff;
    margin: 20px auto;
    max-width: 800px;
    border-radius: 10px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
}
.about h1 {
    font-size: 36px;
    color: #043927;
}
.about span {
    color: #ff9900;
}

/* Steps Section */
.steps {
    text-align: center;
    padding: 50px 20px;
}
.steps h2 {
    font-size: 30px;
    color: #043927;
    margin-bottom: 30px;
}
.step-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}
.step-card {
    background: white;
    padding: 20px;
    margin: 15px;
    width: 250px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    text-align: center;
    transition: 0.3s;
}
.step-card:hover {
    transform: scale(1.05);
}
.step-card i {
    font-size: 40px;
    color: #28a745;
    margin-bottom: 10px;
}
.step-card h3 {
    font-size: 20px;
    margin-bottom: 10px;
}

/* Developer Section */
.developer {
    text-align: center;
    padding: 50px 20px;
    background-color: #fff;
    margin: 20px auto;
    max-width: 800px;
    border-radius: 10px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
}
.dev-card {
    text-align: center;
}
.dev-card img {
    width: 120px;
    border-radius: 50%;
    margin-bottom: 15px;
}
.dev-card h3 {
    font-size: 24px;
    color: #043927;
}
.dev-card p {
    font-size: 16px;
    color: #666;
}
.dev-card a {
    color: #28a745;
    text-decoration: none;
}
.dev-card a:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 768px) {
    .step-card {
        width: 90%;
    }
}

    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">NoteSnap</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php    ">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
            </ul>
        </div>
    </nav>

    <!-- About Section -->
    <section class="about">
        <h1>About <span>NoteSnap</span></h1>
        <p>NoteSnap is an intuitive note-taking web application that helps users create, manage, and access notes easily. Designed for efficiency, it offers a user-friendly interface, secure storage, and seamless PDF downloads.</p>
    </section>

    <!-- Steps Section -->
    <section class="steps">
        <h2>How to Use NoteSnap?</h2>
        <div class="step-container">
            <div class="step-card">
                <i class="fas fa-user-plus"></i>
                <h3>Register</h3>
                <p>Sign up with your email and password to create an account.</p>
            </div>
            <div class="step-card">
                <i class="fas fa-sign-in-alt"></i>
                <h3>Login</h3>
                <p>Enter your credentials to access your notes dashboard.</p>
            </div>
            <div class="step-card">
                <i class="fas fa-edit"></i>
                <h3>Create Notes</h3>
                <p>Write and save notes with a simple and clean editor.</p>
            </div>
            <div class="step-card">
                <i class="fas fa-save"></i>
                <h3>Update & Save</h3>
                <p>Edit and modify your notes anytime before saving.</p>
            </div>
            <div class="step-card">
                <i class="fas fa-trash-alt"></i>
                <h3>Delete Notes</h3>
                <p>Remove notes permanently when no longer needed.</p>
            </div>
            <div class="step-card">
                <i class="fas fa-file-pdf"></i>
                <h3>Download PDF</h3>
                <p>Save your notes offline by downloading them as PDFs.</p>
            </div>
        </div>
    </section>

    <!-- Developer Section -->
    <section class="developer">
        <h2>Meet the Developer</h2>
        <div class="dev-card">
            <img src="src/Profile.jpeg" alt="Logesh N">
            <h3>Logesh N</h3>
            <p>Passionate IT professional with expertise in web development, networking, and automation.</p>
            <p>Email: <a href="mailto:logeshnalliyappan@gmail.com">logeshnalliyappan@gmail.com</a></p>
            <p>Phone: <a href="tel:+917339055427">+91 7339055427</a></p>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <?php include 'footer.php'; ?>

</body>
</html>
