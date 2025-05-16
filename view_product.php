<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$productQuery = $conn->query("SELECT * FROM products ORDER BY id DESC");
$products = $productQuery->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Products - Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 40px;
        }

        .container {
            background: #fff;
            padding: 30px;
            max-width: 1200px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #222;
            color: #fff;
        }

        img {
            height: 60px;
            border-radius: 4px;
        }

        .actions a {
            text-decoration: none;
            margin-right: 10px;
            font-weight: bold;
        }

        .edit {
            color: green;
        }

        .delete {
            color: red;
        }

        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                margin-bottom: 15px;
            }

            td {
                position: relative;
                padding-left: 50%;
                border: none;
                border-bottom: 1px solid #ccc;
            }

            td:before {
                position: absolute;
                left: 10px;
                width: 45%;
                padding-right: 10px;
                font-weight: bold;
                white-space: nowrap;
            }

            td:nth-of-type(1):before { content: "Image"; }
            td:nth-of-type(2):before { content: "Name"; }
            td:nth-of-type(3):before { content: "Price"; }
            td:nth-of-type(4):before { content: "Category"; }
            td:nth-of-type(5):before { content: "Actions"; }
        }
    </style>
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
    <div class="container">
        <h2>All Products</h2>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($product['image_url']) ?>" alt=""></td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td>$<?= htmlspecialchars($product['price']) ?></td>
                        <td><?= htmlspecialchars($product['category']) ?></td>
                        <td class="actions">
                            <a href="edit_product.php?id=<?= $product['id'] ?>" class="edit">Edit</a>
                            <a href="delete_product.php?id=<?= $product['id'] ?>" class="delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
