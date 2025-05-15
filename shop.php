<?php
session_start();
include 'db_connect.php';

$isLoggedIn = isset($_SESSION['user_id']);
$sortOrder = $_GET['sort_order'] ?? 'default';
$search = $_GET['search'] ?? '';

if (!empty($search)) {
    $sql = "SELECT * FROM products WHERE name LIKE ? ORDER BY ";
    $param = '%' . $search . '%';
    $orderClause = $sortOrder == 'low-high' ? 'price ASC' :
                   ($sortOrder == 'high-low' ? 'price DESC' : 'id DESC');
    $sql .= $orderClause;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $param);
} else {
    // Sorting logic as you already have
    if ($sortOrder == 'low-high') {
        $sql = "SELECT * FROM products ORDER BY price ASC";
    } elseif ($sortOrder == 'high-low') {
        $sql = "SELECT * FROM products ORDER BY price DESC";
    } else {
        $sql = "SELECT * FROM products";
    }
    $stmt = $conn->prepare($sql);
}


// Adjust the SQL query based on the sorting option
if ($sortOrder == 'low-high') {
    $sql = "SELECT * FROM products ORDER BY price ASC";
} elseif ($sortOrder == 'high-low') {
    $sql = "SELECT * FROM products ORDER BY price DESC";
} else {
    $sql = "SELECT * FROM products"; // Default order (e.g., by product name or ID)
}

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SwooshX - Shop</title>
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

<section class="shop">
    <h1>ALL COLLECTION</h1>

    <div class="filters">
        <div class="view-options">
            <button id="gridView" class="view-btn active">🔳 Grid</button>
            <button id="listView" class="view-btn">📄 List</button>
        </div>
        <div class="sort-options">
            <label for="sort">Sort By:</label>
            <select id="sort">
                <option value="default" <?php echo ($sortOrder == 'default') ? 'selected' : ''; ?>>Default</option>
                <option value="low-high" <?php echo ($sortOrder == 'low-high') ? 'selected' : ''; ?>>Price: Low to High</option>
                <option value="high-low" <?php echo ($sortOrder == 'high-low') ? 'selected' : ''; ?>>Price: High to Low</option>
            </select>
        </div>
    </div>

    <div class="product-gallery grid-view">
        <?php while ($row = $result->fetch_assoc()) : ?>
            <div class="product-item">
                <img src="<?php echo $row['image_url']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="product-image">
                <div class="product-info">
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p class="price">$<?php echo htmlspecialchars($row['price']); ?></p>
                    <a href="product_details.php?id=<?php echo $row['id']; ?>" class="view-details">View Details</a>

                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>
<script>
$(document).ready(function() {
    // Switch to grid view
    $('#gridView').click(function() {
        $('.product-gallery').removeClass('list-view').addClass('grid-view');
        $(".view-btn").removeClass("active");
        $(this).addClass("active");
    });

    // Switch to list view
    $('#listView').click(function() {
        $('.product-gallery').removeClass('grid-view').addClass('list-view');
        $(".view-btn").removeClass("active");
        $(this).addClass("active");
    });

    // Handle sorting
    $('#sort').change(function() {
        const sort = $(this).val();
        window.location.href = `shop.php?sort_order=${sort}`;
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
