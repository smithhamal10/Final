<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include 'db_connect.php';

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - SwooshX</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .checkout-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }
        .product-summary {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        .product-summary img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 20px;
        }
        .product-details {
            flex: 1;
        }
        .payment-methods {
            display: none;
            margin-top: 20px;
        }
        .btn-place-order {
            background-color: #f2a900;
            color: white;
            padding: 12px 25px;
            border: none;
            font-size: 1.1em;
            border-radius: 8px;
            cursor: pointer;
        }
        .payment-options a {
            display: inline-block;
            margin-right: 20px;
            margin-top: 10px;
            padding: 10px 20px;
            border: 2px solid #333;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body style="font-family: Arial, sans-serif; background-color: grey; color: #333;">
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

<main class="checkout-container">
    <h2 style="text-align: center; font-size: 2em; margin-bottom: 30px;">Checkout</h2>

    <?php
    $grandTotal = 0;
    foreach ($_SESSION['cart'] as $item):
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $item['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) continue;
        $product = $result->fetch_assoc();
        $price = $product['price'];
        $quantity = $item['quantity'];
        $total = $price * $quantity;
        $grandTotal += $total;
    ?>
    <div class="product-summary">
        <img src="<?php echo $product['image_url']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        <div class="product-details">
            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
            <p>Size: <?php echo htmlspecialchars($item['size']); ?></p>
            <p>Price: $<?php echo number_format($price, 2); ?></p>
            <p>Quantity: <?php echo $quantity; ?></p>
            <p>Total: $<?php echo number_format($total, 2); ?></p>
        </div>
    </div>
    <?php endforeach; ?>

    <h3 style="text-align: right; margin-top: 30px;">Grand Total: $<?php echo number_format($grandTotal, 2); ?></h3>

    <div style="text-align: center; margin-top: 30px;">
        <button class="btn-place-order" onclick="document.querySelector('.payment-methods').style.display='block'; this.style.display='none';">Place Order</button>
    </div>

    <div class="payment-methods">
        <h3 style="margin-top: 20px;">Choose Payment Method</h3>
        <div class="payment-options">
            <a href="pay.php?amount=<?php echo $grandTotal; ?>">Pay with Khalti</a>
            <a href="cod_process.php" style="background-color: #4CAF50; color: white;">Cash on Delivery</a>
        </div>
    </div>
</main>

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
