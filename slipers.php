<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Slipers</title>
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
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="wishlist.php">Wishlist</a></li>
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
<section class="featured-products">
         <h2>Slipers</h2>
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
</body>
</html>
