<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in first.");
}

$user_id = $_SESSION['user_id'];

$error_message = '';
$success_message = '';
$total_amount = 0;

// Sanitize helper function
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order']) && $_POST['payment_method'] === 'COD') {
    $total_amount = filter_var($_POST['total_amount'], FILTER_VALIDATE_FLOAT);
    
    // Collect and sanitize form inputs
    $name = isset($_POST['name']) ? sanitize_input($_POST['name']) : '';
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : false;
    $phone = isset($_POST['phone']) ? sanitize_input($_POST['phone']) : '';
    $address = isset($_POST['address']) ? sanitize_input($_POST['address']) : '';

    // Validation
    if ($total_amount === false || $total_amount <= 0) {
        $error_message = "Invalid total amount.";
    } elseif (!$name || !$email || !$phone || !$address) {
        $error_message = "Please fill in all the fields correctly.";
    } elseif (!$email) {
        $error_message = "Invalid email format.";
    } else {
        try {
            // Insert order with customer info
            $stmt = $conn->prepare("INSERT INTO orders (user_id, amount, status, payment_method, created_at, customer_name, customer_email, customer_phone, delivery_address) VALUES (?, ?, 'Pending', 'Cash on Delivery', NOW(), ?, ?, ?, ?)");
            $stmt->bind_param("idssss", $user_id, $total_amount, $name, $email, $phone, $address);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $order_id = $stmt->insert_id;

                $cart_stmt = $conn->prepare("SELECT product_id, quantity FROM cart WHERE user_id = ?");
                $cart_stmt->bind_param("i", $user_id);
                $cart_stmt->execute();
                $cart_result = $cart_stmt->get_result();

                if ($cart_result->num_rows > 0) {
                    $detail_stmt = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity) VALUES (?, ?, ?)");
                    while ($item = $cart_result->fetch_assoc()) {
                        $detail_stmt->bind_param("iii", $order_id, $item['product_id'], $item['quantity']);
                        $detail_stmt->execute();
                    }
                }

                $clear_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
                $clear_cart->bind_param("i", $user_id);
                $clear_cart->execute();

                $success_message = "<h2>Order Placed Successfully!</h2>
                    <p>Payment Method: Cash on Delivery</p>
                    <p>Total Amount: Rs. " . number_format($total_amount, 2) . "</p>
                    <p><a href='home.php'>Return to Home</a></p>";
            } else {
                $error_message = "Failed to place order.";
            }
        } catch (Exception $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    }
} elseif (isset($_POST['total_amount'])) {
    $total_amount = filter_var($_POST['total_amount'], FILTER_VALIDATE_FLOAT);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Cash on Delivery</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        /* Minimal styling for form */
        label {
            display: block;
            margin-bottom: 6px;
            color: white;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: none;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
        }
        button {
            padding: 12px 30px;
            font-size: 16px;
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #333;
        }
        .error {
            color: #ff5555;
            margin-top: 10px;
            font-weight: bold;
        }
        .success {
            color: #88cc88;
            font-size: 18px;
        }
    </style>
</head>
<body>
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
<div style="max-width: 500px; margin: 50px auto; background:black
; padding: 30px 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.7); color: white;">

    <?php if ($success_message): ?>
        <div class="success" style="text-align: center;">
            <?php echo $success_message; ?>
        </div>
    <?php else: ?>
        <h2 style="font-size: 24px; margin-bottom: 20px; text-align: center;">Cash on Delivery</h2>
        <p style="font-size: 18px; margin-bottom: 30px; text-align: center;">
            <strong>Total Amount:</strong> Rs. <?php echo number_format($total_amount, 2); ?>
        </p>

        <form method="POST" action="cod_process.php" novalidate>
            <input type="hidden" name="payment_method" value="COD" />
            <input type="hidden" name="total_amount" value="<?php echo htmlspecialchars($total_amount); ?>" />

            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required />

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required />

            <label for="phone">Contact Number</label>
            <input type="tel" id="phone" name="phone" required />

            <label for="address">Delivery Address</label>
            <textarea id="address" name="address" rows="4" required></textarea>

            <button type="submit" name="place_order">Place Order</button>

            <?php if ($error_message): ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php endif; ?>
        </form>
    <?php endif; ?>

</div>

<!-- Footer -->
<footer style="background: #000; color: white; padding: 20px; text-align: center;">
    <div class="footer-container">
        <div class="footer-logo" style="font-weight: bold; font-size: 20px; margin-bottom: 10px;">SwooshX</div>
        <div class="footer-links" style="margin-bottom: 10px;">
            <a href="home.php" style="color: white; margin: 0 10px; text-decoration: none;">Home</a>
            <a href="shop.php" style="color: white; margin: 0 10px; text-decoration: none;">Shop</a>
            <a href="about.php" style="color: white; margin: 0 10px; text-decoration: none;">About</a>
            <a href="contact.php" style="color: white; margin: 0 10px; text-decoration: none;">Contact</a>
        </div>
        <div class="footer-socials" style="margin-bottom: 10px;">
            <a href="https://www.facebook.com" target="_blank" style="color: white; margin: 0 8px;"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.instagram.com" target="_blank" style="color: white; margin: 0 8px;"><i class="fab fa-instagram"></i></a>
            <a href="https://www.twitter.com" target="_blank" style="color: white; margin: 0 8px;"><i class="fab fa-twitter"></i></a>
            <a href="https://www.youtube.com" target="_blank" style="color: white; margin: 0 8px;"><i class="fab fa-youtube"></i></a>
        </div>
        <div class="footer-info">
            <p>&copy; <?php echo date("Y"); ?> SwooshX. All rights reserved.</p>
        </div>
    </div>
</footer>

</body>
</html>
