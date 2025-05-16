<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Only process form data when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Safely access all form fields
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $imageUrl = trim($_POST['image_url'] ?? '');

    if (!empty($name) && !empty($price) && !empty($imageUrl) && !empty($category)) {
        $stmt = $conn->prepare("INSERT INTO products (name, price, image_url, category, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("sdss", $name, $price, $imageUrl, $category);

        if ($stmt->execute()) {
            $message = "Product added successfully!";
        } else {
            $message = "Error adding product: " . $conn->error;
        }

        $stmt->close();
    } else {
        $message = "All fields are required!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <style>
        body {
            background: #fafafa;
            color: #333;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background-color: #222;
            color: #fff;
        }
        header .logo {
            font-size: 28px;
            font-weight: bold;
        }
        nav ul {
            list-style: none;
            display: flex;
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 16px;
            transition: color 0.3s ease;
        }
        .dashboard-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            font-size: 28px;
        }
        .form-container {
            margin-bottom: 30px;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
            max-width: 500px;
            margin: 0 auto;
        }
        .form-container label {
            margin-bottom: 10px;
            font-size: 16px;
        }
        .form-container input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }
        .form-container button {
            padding: 10px;
            background-color: #ff6600;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #e65c00;
        }
        .message {
            text-align: center;
            font-size: 16px;
            color: green;
            margin-bottom: 15px;
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
<div class="dashboard-container">
    <h1>Manage Products</h1>
    
    <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
    
    <div class="form-container">
        <form method="POST" action="">
    <label>Product Name:</label>
    <input type="text" name="name" required>

    <label>Price:</label>
    <input type="number" step="0.01" name="price" required>

    <label>Category:</label>
    <input type="text" name="category" required>

    <label>Product Image URL:</label>
    <input type="text" name="image_url" placeholder="Enter image URL" required>

    <button type="submit">Add Product</button>
</form>
    </div>
</div>
</body>
</html>
