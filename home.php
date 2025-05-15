<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwooshX - Home</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="description" content="Shop the latest Nike shoes at SwooshX – from Air Jordans to Running Shoes. Fast shipping, easy returns, 100% authentic.">

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
<div class="promo-banner">
  <p>🔥 Summer Sale - Up to 50% Off on Selected Styles! 🔥</p>
</div>
<section class="hero">
    <div class="banner-wrapper">
        <div class="banner-slide">
            <img src="shoes4.jpg" alt="Hero Banner" class="hero-image">
            <div class="banner-caption">
                <h1>Step Into Style with SwooshX</h1>
                <p>Find the best shoes for every occasion.</p>
            </div>
        </div>
        <div class="banner-slide">
            <img src="shoes1.jpg" alt="Featured Banner 2" class="hero-image">
            <div class="banner-caption">
                <h1>Fresh Arrivals Just In</h1>
                <p>Be the first to rock the newest styles.</p>
            </div>
        </div>
        <div class="banner-slide">
            <img src="shoes2.jpg" alt="Featured Banner 2" class="hero-image">
            <div class="banner-caption">
                <h1>Bestest shoes Ever</h1>
                <p>Be the first to rock the newest styles.</p>
            </div>
        </div>
    </div>
</section>
<section class="categories">
    <h2>Brand Category</h2>
    <div class="category-gallery">
        <div class="category-item">
        <a href="Nike.php"><img src="https://imgs.search.brave.com/YdQ7tNBAyQajwX_m_a4rt5o6103X1f9IiDvpNUpYtIg/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5kZXNpZ25ydXNo/LmNvbS9pbnNwaXJh/dGlvbl9pbWFnZXMv/MTM0ODA1L2NvbnZl/cnNpb25zL18xNTEy/MDc2ODAzXzkzX05p/a2UtZGVza3RvcC5q/cGc" ></a>
                <h3>Nike</h3>
        </div>
        <div class="category-item">
        <a href="Adidas.php"><img src="https://imgs.search.brave.com/bIQGbeClEj4QdNgFRp2r-TqPJKKd6F8RMN4O2PR8rnw/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly9wcmV2/aWV3LnRoZW5ld3Nt/YXJrZXQuY29tL1By/ZXZpZXdzL0FESUQv/U3RpbGxBc3NldHMv/OTYweDU0MC82ODkz/NDcuanBn" ></a>
                <h3>Adidas</h3>
        </div>
        <div class="category-item">
        <a href="NB.php"><img src="https://i.pinimg.com/736x/e0/8c/de/e08cde2f956d6768fc44216a9b89ff6e.jpg" ></a>
                <h3>New Balance</h3>
        </div>
        <div class="category-item">
        <a href="puma.php"><img src="https://www.logomagicians.com/wp-content/uploads/2024/02/What-is-Puma.webp"></a>
                <h3>puma</h3>
        </div>
    </div>
</section>
<section class="featured-products">
         <h2>Top Sellers Shoes</h2>
        <div class="product-gallery">
        <div class="product-item">
        <img src="https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/8ed56989-0a03-4186-a61a-bad7acf1b135/A%27ONE.png" alt="Nike Air Max 90">
        <h3>A'One "Pink A'ura"</h3>
    </div>
    <div class="product-item">
        <img src="https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/b7d9211c-26e7-431a-ac24-b0540fb3c00f/AIR+FORCE+1+%2707.png" alt="Nike Air Force 1">
        <h3>Nike Air Force 1</h3>
    </div>
    <div class="product-item">
        <img src="https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/b1bcbca4-e853-4df7-b329-5be3c61ee057/NIKE+DUNK+LOW+RETRO.png" alt="Nike Dunk Low">
        <h3>Nike Dunk Low Retro</h3>
    </div>
    <div class="product-item">
        <img src="https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco,u_126ab356-44d8-4a06-89b4-fcdcc8df0245,c_scale,fl_relative,w_1.0,h_1.0,fl_layer_apply/acab811c-3989-4b3d-bd84-ece6f0ddb845/AIR+JORDAN+1+MID+SE.png" alt="Air Jordan 1 Mid">
        <h3>Air Jordan 1 Mid SE</h3>
    </div>
    </section>
    <section class="new-arrivals">
    <h2>New Arrivals</h2>
    <div class="product-gallery">
        <div class="product-item2">
            <img src="https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/df641e74-858a-4b8e-bb04-dbf7efc8ccff/AIR+MAX+DN8.png" alt="Nike Air Max DN">
            <h3>Nike Air Max Dn8</h3>
        </div>
        <div class="product-item2">
            <img src="https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco,u_126ab356-44d8-4a06-89b4-fcdcc8df0245,c_scale,fl_relative,w_1.0,h_1.0,fl_layer_apply/693f9b4d-95da-4df4-916e-f05c35c850d8/AIR+JORDAN+1+RETRO+HIGH+OG.png" alt="Air Jordan 6 Retro">
            <h3>Air Jordan 1 Retro High OG "UNC Reimagined"</h3>
        </div>
        <div class="product-item2">
            <img src="https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco,u_126ab356-44d8-4a06-89b4-fcdcc8df0245,c_scale,fl_relative,w_1.0,h_1.0,fl_layer_apply/b1858082-d293-4d0f-91b1-44cdf291ee90/JORDAN+SPIZIKE+LOW.png" alt="Jordan Spizike Low">
            <h3>Jordan Spizike Low</h3>
        </div>
        <div class="product-item2">
            <img src="https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/e0a19996-b64a-458d-855a-1e508832736d/NIKE+AIR+MAX+1+ESS.png" alt="Nike Air Max 1">
            <h3>Nike Air Max 1 Essential</h3>
        </div>
    </div>
</section>
<section class="why-choose-us">
    <h2>Why Choose SwooshX?</h2>
    <div class="features-grid">
        <div class="feature-box">
            <img src="https://imgs.search.brave.com/FNNFX6vbVa7Z0LnVADyedby_C5n40P7EUfYDBTQChY8/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5nZXR0eWltYWdl/cy5jb20vaWQvMTQ5/MTY2MDgyMy92ZWN0/b3IvZmFzdC1zaGlw/cGluZy10aGluLWxp/bmVzLWljb24uanBn/P3M9NjEyeDYxMiZ3/PTAmaz0yMCZjPVZq/aFNrNEJiQjBFQzdo/bGxZemRxWk5jV0Ft/aWlIX0kwd0ZwNDhF/aHZyZ289" alt="Fast Shipping">
            <h3>Fast Shipping</h3>
            <p>Get your kicks delivered quickly with our express shipping options worldwide.</p>
        </div>
        <div class="feature-box">
            <img src="https://imgs.search.brave.com/pBfBsCxYDb3JH_qhPSfyZibeYOfC8W3vmbZVYmONL-o/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzA3LzAyLzM3LzM2/LzM2MF9GXzcwMjM3/MzY0N19HY2d5eGdw/RVlEaGI3N1lVQXNQ/cHNsZ1l1OEJtbWRH/YS5qcGc" alt="100% Authentic">
            <h3>100% Authentic</h3>
            <p>We guarantee genuine products—no fakes, no replicas, just the real deal.</p>
        </div>
        <div class="feature-box">
            <img src="https://imgs.search.brave.com/3JiO0tEML9yOF_nEhFMXhzQecSvFRRnN_RQIW8c_zQA/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzExLzQwLzQzLzg2/LzM2MF9GXzExNDA0/Mzg2MjZfNUs1QXAx/NzQ5bHBNZGRVZ1Bp/OFJMYkZWYk56M0VI/M00uanBn" alt="Easy Returns">
            <h3>Easy Returns</h3>
            <p>Not the right fit? No problem. Enjoy hassle-free 14-day returns on all items.</p>
        </div>
        <div class="feature-box">
            <img src="https://imgs.search.brave.com/6CZHWLbSYMbSyNxl8oF7kydpkU-hfhinTdqNQ7qxNds/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvMTE2/MjMzNjM3NC92ZWN0/b3IvMjQtaG91cnMt/aWNvbi5qcGc_cz02/MTJ4NjEyJnc9MCZr/PTIwJmM9T0RWVmNM/MlhJcmJSam1JSzlk/ZkVmQmZGdHdFM2xs/STJSVTR1b0h3Tlg2/Yz0" alt="24/7 Support">
            <h3>24/7 Support</h3>
            <p>Our friendly team is available around the clock to help with anything you need.</p>
        </div>
    </div>
</section>
<!-- Google Review Section -->
<section class="google-review-box">
  <div class="review-content">
    <img src="https://imgs.search.brave.com/C-CpKe6GZ8S3z492ovKtc2ZwgD3EA8Bn7F1SjKzB3Dw/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly90aGVs/b2dvY29tcGFueS5u/ZXQvd3AtY29udGVu/dC91cGxvYWRzLzIw/MjIvMDMvYWRtaXJh/bC0yLTMwMHgzMDAu/cG5n" alt="Google Logo" class="google-logo">
    <h2>Rate Us on Google</h2>
    <div class="star-rating">
      <i class="fas fa-star" data-value="1"></i>
      <i class="fas fa-star" data-value="2"></i>
      <i class="fas fa-star" data-value="3"></i>
      <i class="fas fa-star" data-value="4"></i>
      <i class="fas fa-star" data-value="5"></i>
    </div>
    <p>Your feedback helps us improve and grow!</p>
    <a href="https://console.cloud.google.com/google/maps-hosted/build?inv=1&invt=AbxGLg&authuser=4" target="_blank" class="review-button">
      Write a Review
    </a>
  </div>
</section>


<section class="subscribe-section">
    <div class="subscribe-container">
        <div class="ad-section">
            <!-- You can use image ads or embed ad scripts here -->
            <img src="https://media3.giphy.com/media/v1.Y2lkPTc5MGI3NjExdHhmczFidDRlZHcwbG4wcXlxcXM4enJ6b2pwc3ZsdXN2amtqbGN6ciZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/26FlruUbK9XSEQDoQ/giphy.gif" alt="Ad" class="ad-image">
        </div>
        <div class="subscribe-form-section">
            <h2>Subscribe to Our Newsletter</h2>
            <p>Get the latest updates on new arrivals and exclusive offers.</p>
            <form action="subscribe.php" method="post" class="subscribe-form">
                <input type="email" name="email" placeholder="Enter your email address" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </div>
</section>
    <script src="script.js">
          document.querySelectorAll('.star-rating i').forEach(star => {
        star.addEventListener('click', () => {
            const rating = star.getAttribute('data-value');
            alert(`You rated us ${rating} stars!`);
        });
    });
    </script>  
    <footer>
    <div class="footer-container">
        <div class="footer-logo">SwooshX</div>
        <div class="footer-links">
            <a href="home.php">Home</a>
            <a href="shop.php">Shop</a>
            <a href="about.html">About</a>
            <a href="contact.html">Contact</a>
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
