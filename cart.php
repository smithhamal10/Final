<?php 
session_start();
include 'db_connect.php';
$isLoggedIn = isset($_SESSION['user_id']);
$search = isset($_GET['search']) ? $_GET['search'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwooshX - Cart</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <section class="cart">
        <h1>Your Cart</h1>

        <?php if ($isLoggedIn): ?>
            <div class="cart-items">
                <?php
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT cart.id, cart.quantity, products.name, products.price, products.image_url FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                $totalPrice = 0;

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $subtotal = $row['price'] * $row['quantity'];
                        $totalPrice += $subtotal;
                        ?>
                        <div class="cart-item" data-cart-id="<?php echo $row['id']; ?>">
                            <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>">
                            <div class="item-details">
                                <h3><?php echo $row['name']; ?></h3>
                                <p>Price: <?php echo number_format($row['price'], 2); ?></p>
                                <p>Quantity: <span class="quantity"><?php echo $row['quantity']; ?></span></p>
                                <p>Subtotal: <span class="subtotal"><?php echo number_format($subtotal, 2); ?></span></p>
                            </div>
                            <button class="remove-item">Remove</button>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p>Your cart is empty.</p>';
                }
                ?>
            </div>

            <div class="cart-summary">
                <p>Total: <span id="total-price"><?php echo number_format($totalPrice, 2); ?></span></p>
                <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
            </div>
        <?php else: ?>
            <div class="login-message">
                <p>Please <a href="login.html">log in</a> to view your cart.</p>
            </div>
        <?php endif; ?>
    </section>

    <script>
        $(document).ready(function() {
            $(".remove-item").click(function() {
                var cartItem = $(this).closest('.cart-item');
                var cartId = cartItem.data("cart-id");

                $.ajax({
                    url: "remove.php",
                    method: "POST",
                    data: { cart_id: cartId },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            cartItem.remove();
                            $("#total-price").text(response.new_total);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert("Error removing item.");
                    }
                });
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