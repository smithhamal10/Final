<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in first.");
}

$user_id = $_SESSION['user_id'];
$error_message = "";
$total_amount = 0;

// Fetch cart items and calculate total
$cart_stmt = $conn->prepare("SELECT c.product_id, c.quantity, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$cart_stmt->bind_param("i", $user_id);
$cart_stmt->execute();
$cart_result = $cart_stmt->get_result();

$cart_items = [];
if ($cart_result && $cart_result->num_rows > 0) {
    while ($row = $cart_result->fetch_assoc()) {
        $cart_items[] = $row;
        $total_amount += $row['price'] * $row['quantity'];
    }
} else {
    $error_message = "Your cart is empty.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order']) && $_POST['payment_method'] === 'COD') {
    if (empty($cart_items)) {
        $error_message = "Your cart is empty.";
    } else {
        try {
            // Insert order
            $stmt = $conn->prepare("INSERT INTO orders (user_id, amount, status, payment_method, created_at) VALUES (?, ?, 'Pending', 'Cash on Delivery', NOW())");
            $stmt->bind_param("id", $user_id, $total_amount);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $order_id = $stmt->insert_id;

                // Insert order details
                $detail_stmt = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity) VALUES (?, ?, ?)");
                foreach ($cart_items as $item) {
                    $detail_stmt->bind_param("iii", $order_id, $item['product_id'], $item['quantity']);
                    $detail_stmt->execute();
                }

                // Clear cart
                $clear_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
                $clear_cart->bind_param("i", $user_id);
                $clear_cart->execute();

                // Redirect or show confirmation
                header("Location: order_success.php?order_id=$order_id");
                exit();
            } else {
                $error_message = "Failed to place order.";
            }
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cash on Delivery</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f1f1f1; margin: 0; padding: 0;">

<!-- Header -->
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

<!-- Main Content -->
<div style="max-width: 90%; width: 500px; margin: 50px auto; background: white; padding: 30px 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); text-align: center;">
    <h2 style="font-size: 24px; color: black; margin-bottom: 20px;">Cash on Delivery</h2>
    <p style="font-size: 18px; color:black; margin-bottom: 30px;"><strong>Total Amount:</strong> Rs. <?php echo number_format($total_amount, 2); ?></p>

    <?php if (!$error_message): ?>
        <form method="POST" action="cod_process.php">
    <input type="hidden" name="payment_method" value="COD">
    <input type="hidden" name="total_amount" value="<?php echo htmlspecialchars($total_amount); ?>">
    <button type="submit" name="place_order" style="padding: 12px 30px; font-size: 16px; background-color: #000; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
        Place Order
    </button>
</form>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <p style="color: red; margin-top: 20px;"><?php echo $error_message; ?></p>
    <?php endif; ?>
</div>

<!-- Footer -->
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
