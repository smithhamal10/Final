<?php
session_start();
require 'db_connect.php'; // assumes you have this to connect to your DB

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch wishlist items
$sql = "SELECT products.id, products.name, products.description, products.image_url 
        FROM wishlist 
        JOIN products ON wishlist.product_id = products.id 
        WHERE wishlist.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Wishlist</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <!-- reuse same header from home.php -->
        <div class="logo">SwooshX</div>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="wishlist.php">Wishlist</a></li>
                <li><a href="cart.php">Cart</a></li>
                
            </ul>
        </nav>
    </header>

    <main>
        <h1>Your Wishlist</h1>
        <div class="wishlist-container">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="wishlist-item">
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Product Image">
                        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <a href="remove_from_wishlist.php?product_id=<?php echo $row['id']; ?>" class="remove-btn">Remove</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Your wishlist is empty.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
