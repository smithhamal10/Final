<?php
session_start();
include('db_connect.php'); // Ensure this connects to your database using MySQLi

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
$totalOrdersQuery = $conn->query("SELECT COUNT(*) AS total_orders FROM orders");
if (!$totalOrdersQuery) {
    die("Query failed (total orders): " . $conn->error);
}
$totalOrders = $totalOrdersQuery->fetch_assoc()['total_orders'];

// Fetch new users count (users created in the last 30 days)
$newUsersQuery = $conn->query("SELECT COUNT(*) AS new_users FROM users WHERE created_at >= NOW() - INTERVAL 30 DAY");
$newUsers = $newUsersQuery->fetch_assoc()['new_users'];

// Fetch recent contact messages
$messagesQuery = $conn->query("SELECT * FROM contact_messages ORDER BY id DESC LIMIT 10");
$messages = $messagesQuery->fetch_all(MYSQLI_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> SwooshX-Admin Dashboard</title>
</head>
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

<div class="dashboard-container" style="max-width: 1200px; margin: 40px auto; padding: 20px; background: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px;">
    <h1 style="text-align: center; margin-bottom: 20px; font-size: 28px; color: #222;">Admin Dashboard</h1>
    
    <div class="stats" style="display: flex; justify-content: space-around; margin-bottom: 30px;">
        <div style="padding: 20px; background: #ff6600; color: #fff; font-size: 20px; font-weight: bold; border-radius: 8px; text-align: center; width: 200px;">Total Orders: <?php echo $totalOrders; ?></div>
        
        <div style="padding: 20px; background: #ff6600; color: #fff; font-size: 20px; font-weight: bold; border-radius: 8px; text-align: center; width: 200px;">New Users: <?php echo $newUsers; ?></div>
    </div>
</div>
</body>
</html>