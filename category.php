<?php
session_start();
include 'db_connect.php';

$isLoggedIn = isset($_SESSION['user_id']);
$brand = isset($_GET['brand']) ? trim($_GET['brand']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($brand); ?> Collection</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            </ul>
        </nav>
    </div>
    <div class="header-right">
        <form class="search-form" action="shop.php" method="get">
            <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>" />
            <button type="submit">🔍</button>
        </form>
        <a href="cart.php" class="icon-link">🛒</a>
        <?php if ($isLoggedIn): ?>
            <a href="logout.php" class="icon-link">Logout</a>
        <?php else: ?>
            <a href="login.html" class="icon-link">Login</a>
        <?php endif; ?>
    </div>
</header>

<section class="shop">
    <h1><?php echo htmlspecialchars($brand); ?> Collection</h1>

    <div class="product-gallery">
        <?php
        if ($brand !== '') {
            $sql = "SELECT * FROM products WHERE brand = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $brand);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                    <div class="product-item">
                        <img src="' . $row['image_url'] . '" alt="' . htmlspecialchars($row['name']) . '">
                        <div class="product-details">
                            <h3>' . htmlspecialchars($row['name']) . '</h3>
                            <p class="price">$' . htmlspecialchars($row['price']) . '</p>
                            <p class="description">' . htmlspecialchars($row['description']) . '</p>
                            <p class="size">Size: ' . htmlspecialchars($row['size']) . '</p>';
                    if ($isLoggedIn) {
                        echo '<button class="add-to-cart" data-product-id="' . $row['id'] . '">Add to Cart</button>';
                    }
                    echo '</div></div>';
                }
            } else {
                echo '<p>No products found for this brand.</p>';
            }
        } else {
            echo '<p>Brand not specified.</p>';
        }
        ?>
    </div>
</section>

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
