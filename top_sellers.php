<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$result = $conn->query("SELECT * FROM top_sellers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Top Sellers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .card img {
            width: 100%;
            max-height: 180px;
            object-fit: contain;
            border-radius: 6px;
        }
        .product-name {
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
            color: #444;
        }
    </style>
</head>
<body>
<body style="background: #fafafa; color: #333; font-family: Arial, sans-serif; margin: 0; padding: 0;">
<header style="display: flex; justify-content: space-between; align-items: center; padding: 20px 40px; background-color: #222; color: #fff;">
    <div class="logo" style="font-size: 28px; font-weight: bold; letter-spacing: 1px;"> SwooshX-Admin Panel</div>
    <nav>
        <ul style="list-style: none; display: flex;">
            <li style="margin: 0 15px;"><a href="admin_dashboard.php" style="text-decoration: none; color: #fff; font-size: 16px;">Dashboard</a></li>
            <li style="margin: 0 15px;"><a href="manage_product.php" style="text-decoration: none; color: #fff; font-size: 16px;">Manage Products</a></li>
            <li style="margin: 0 15px;"><a href="top_sellers.php" style="text-decoration: none; color: #fff; font-size: 16px;">Top Sellers</a></li>
            <li style="margin: 0 15px;"><a href="new_arrivals.php" style="text-decoration: none; color: #fff; font-size: 16px;">New arrivals</a></li>
            <li style="margin: 0 15px;"><a href="view_product.php" style="text-decoration: none; color: #fff; font-size: 16px;">View Product</a></li>
             <li style="margin: 0 15px;"><a href="view_messages.php" style="text-decoration: none; color: #fff; font-size: 16px;">View Messages</a></li>
            <li style="margin: 0 15px;"><a href="order.php" style="text-decoration: none; color: #fff; font-size: 16px;">Orders</a></li>
            <li style="margin: 0 15px;"><a href="logout.php" style="text-decoration: none; color: #fff; font-size: 16px;">Logout</a></li>
        </ul>
    </nav>
</header>
<h1>Top Selling Products</h1>
<div class="grid">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card">
            <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>">
            <div class="product-name"><?php echo htmlspecialchars($row['product_name']); ?></div>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
