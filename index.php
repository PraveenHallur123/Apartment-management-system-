<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apartment Management System</title>
    <link rel="stylesheet" href="styless.css"> <!-- Link to your CSS file for styling -->
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Header Section -->
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Tenant Login</a></li>
                <li><a href="adminLogin.php">Admin Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Section -->
    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Welcome to the Apartment Management System</h1>
                <p>Your one-stop platform for booking apartments, making payments, and submitting maintenance requests.</p>
                <a href="register.php" class="btn">Get Started</a>
            </div>
        </section>

        

        <section class="features">
            <h2>Our Key Features</h2>
            <div class="feature-item">
                <h3>Find & Book Apartments</h3>
                <p>Browse through available apartments and book your dream home in no time.</p>
            </div>
            <div class="feature-item">
                <h3>Secure Payments</h3>
                <p>Pay your rent securely and on time using our integrated payment system.</p>
            </div>
            <div class="feature-item">
                <h3>Maintenance Requests</h3>
                <p>Easily submit maintenance requests and track their progress.</p>
            </div>
        </section>

        <section class="about">
            <h2>About Us</h2>
            <p>We provide a seamless experience for both tenants and property managers, making renting and managing properties easier for everyone. Whether you’re looking for an apartment or managing tenants, we’re here to help.</p>
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <div class="footer-container">
            <p>&copy; 2025 Apartment Management System | All Rights Reserved</p>
            <p>Contact us: <a href="mailto:praveenhallur2003@gmail.com">praveenhallur2003@gmail.com</a></p>

             <!-- Social Media Icons -->
        <div class="social-media">
            <a href="https://www.facebook.com" target="_blank" class="social-icon"><i class="fab fa-facebook"></i></a>
            <a href="https://www.twitter.com" target="_blank" class="social-icon"><i class="fab fa-twitter"></i></a>
            <a href="https://www.instagram.com" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
            <a href="https://www.linkedin.com" target="_blank" class="social-icon"><i class="fab fa-linkedin"></i></a>
        </div>
    </div>
    
        </div>
    </footer>

</body>
</html>
