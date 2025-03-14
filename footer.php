<style>
    /* Footer */
.footer {
    background: #043927;
    color: white;
    padding: 40px 0;
    font-family: 'Poppins', sans-serif;
}
.footer .container {
    width: 90%;
    margin: auto;
}
.footer .row {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}
.footer-col {
    width: 25%;
    padding: 10px;
}
.footer-col h4 {
    font-size: 18px;
    color: #fff;
    margin-bottom: 15px;
    position: relative;
}
.footer-col ul {
    list-style: none;
    padding: 0;
}
.footer-col ul li {
    margin-bottom: 8px;
}
.footer-col ul li a {
    color: #bbb;
    text-decoration: none;
    transition: 0.3s;
}
.footer-col ul li a:hover {
    color: #ff9900;
}
.footer-col .social-links {
    display: flex;
    gap: 10px;
}
.footer-col .social-links a {
    color: #fff;
    font-size: 18px;
    border: 1px solid white;
    padding: 8px;
    border-radius: 50%;
    transition: 0.3s;
}
.footer-col .social-links a:hover {
    background: #ff9900;
    color: white;
    border-color:rgb(255, 255, 255);
}

/* Copyright */
.footer-bottom {
    text-align: center;
    margin-top: 20px;
    font-size: 14px;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    padding-top: 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .footer .row {
        flex-direction: column;
        text-align: center;
    }
    .footer-col {
        width: 100%;
    }
}

</style>

<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="footer-col">
                <h4>About NoteSnap</h4>
                <p>NoteSnap is an intuitive note-taking web app that helps you create, manage, and download notes as PDFs effortlessly.</p>
            </div>

            <!-- Quick Links -->
           

            <!-- Contact Info -->
            <div class="footer-col">
                <h4>Contact Us</h4>
                <ul>
                    <li><i class="fas fa-envelope"></i> <a href="mailto:logeshnalliyappan@gmail.com">logeshnalliyappan@gmail.com</a></li>
                    <li><i class="fas fa-phone"></i> <a href="tel:+917339055427">+91 7339055427</a></li>
                    <li><i class="fas fa-link"></i> <a href="https://logesh0108.github.io/Personal-Website/Portfolio-main/">Portfolio</a></li>
                    <li><i class="fas fa-map-marker-alt"></i> Namakkal, Tamil Nadu</li>
                </ul>
            </div>

            <!-- Social Media -->
            <div class="footer-col">
                <h4>Follow Us</h4>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="footer-bottom">
            <p>&copy; <?php echo date("Y"); ?> NoteSnap. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- FontAwesome Icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

