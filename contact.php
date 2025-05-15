<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - SwooshX</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <header class="main-header">
        <div class="header-left">
            <div class="logo">SwooshX</div>
        </div>
        <div class="header-center">
            <nav class="main-nav">
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
        
        </div>
        <div class="header-right">
            <form class="search-form" action="shop.php" method="get">
                <input type="text" name="search" placeholder="Search products..." />
                <button type="submit">🔍</button>
            </form>
            <a href="cart.php" class="icon-link">🛒</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="icon-link">Logout</a>
            <?php else: ?>
                <a href="login.html" class="icon-link">Login</a>
            <?php endif; ?>
        </div>
    </header>
    
    <section class="contact">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you. Fill out the form below and we'll get back to you as soon as possible.</p>
        <form class="contact-form" action="contact_process.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="6" placeholder="Enter your message" required></textarea>
            </div>
            <button type="submit" class="submit-btn">Send Message</button>
        </form>
    </section>
    
    <script src="script.js"></script>
    <footer>
        <div class="footer-container">
            <div class="footer-logo">SwooshX</div>
    
            <div class="footer-links">
                <a href="home.php">Home</a>
                <a href="shop.php">Shop</a>
                <a href="about.php">About</a>
                <a href="contact.php">Contact</a>
            </div>
            <div class="footer-socials">
                <a href="https://www.facebook.com" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="https://www.twitter.com" target="_blank" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="https://www.youtube.com" target="_blank" class="social-icon"><i class="fab fa-youtube"></i></a>
            </div>
            <div class="footer-info">
                <p>&copy; <?php echo date("Y"); ?> SwooshX. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
