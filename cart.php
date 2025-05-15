<?php
session_start();
include 'db_connect.php';

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle adding to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['size'])) {
    $productId = intval($_POST['product_id']);
    $size = $_POST['size'];

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] === $productId && $item['size'] === $size) {
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $productId,
            'size' => $size,
            'quantity' => 1
        ];
    }

    header("Location: cart.php");
    exit;
}

// Handle remove
if (isset($_GET['remove'])) {
    $index = intval($_GET['remove']);
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index
    }
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Shopping Cart</title>
    <link rel="stylesheet" href="styles.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

<main style="max-width: 1200px; margin: 40px auto; padding: 20px; background-color: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
    <h1 style="font-size: 2.5em; margin-bottom: 20px; text-align: center;">Your Shopping Cart</h1>

    <?php if (empty($_SESSION['cart'])): ?>
        <p style="text-align: center; font-size: 1.5em;">Your cart is empty.</p>
    <?php else: ?>
        <?php
        $grandTotal = 0;
        foreach ($_SESSION['cart'] as $index => $cartItem):
            $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->bind_param("i", $cartItem['id']);
            $stmt->execute();
            $productResult = $stmt->get_result();

            if ($productResult->num_rows === 0) continue;
            $product = $productResult->fetch_assoc();

            $price = $product['price'];
            $quantity = $cartItem['quantity'];
            $totalPrice = $price * $quantity;
            $grandTotal += $totalPrice;
        ?>
        <div style="display: flex; margin-bottom: 20px; border-bottom: 1px solid #eaeaea; padding-bottom: 20px;">
            <img src="<?php echo $product['image_url']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px; margin-right: 20px;">
            <div style="flex: 1;">
                <h3 style="font-size: 1.25em; margin-bottom: 10px;"><?php echo htmlspecialchars($product['name']); ?></h3>
                <p style="font-size: 1em; margin-bottom: 5px;">Size: <?php echo htmlspecialchars($cartItem['size']); ?></p>
                <p style="font-size: 1em; margin-bottom: 5px;">Price: $<?php echo number_format($price, 2); ?></p>
                <p style="font-size: 1em; margin-bottom: 5px;">Quantity: <?php echo $quantity; ?></p>
                <p style="font-size: 1em; margin-bottom: 5px;">Total: $<?php echo number_format($totalPrice, 2); ?></p>
            </div>
            <div style="display: flex; flex-direction: column; justify-content: center;">
                <a href="cart.php?remove=<?php echo $index; ?>" style="color: #e53935; font-size: 1em; text-decoration: none;">Remove</a>
            </div>
        </div>
        <?php endforeach; ?>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px; font-size: 1.5em;">
            <div style="font-weight: bold;">Grand Total: $<?php echo number_format($grandTotal, 2); ?></div>
            <?php if (!empty($_SESSION['cart'])): ?>
                <a href="checkout.php" style="background-color: #f2a900; color: white; padding: 10px 20px; font-size: 1.2em; border: none; border-radius: 8px; text-decoration: none; cursor: pointer; margin-left: 20px;">Proceed to Checkout</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
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
