<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Fetch messages
$messagesQuery = $conn->query("SELECT * FROM contact_messages ORDER BY id DESC");
$messages = $messagesQuery->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Messages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
        }

        header {
            background: #222;
            color: #fff;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 26px;
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
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #222;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #333;
            color: #fff;
        }

        @media screen and (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead {
                display: none;
            }

            tr {
                margin-bottom: 15px;
                background: #f9f9f9;
                border-radius: 6px;
                box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                padding: 12px;
            }

            td {
                position: relative;
                padding-left: 50%;
                font-size: 14px;
            }

            td::before {
                position: absolute;
                left: 15px;
                top: 12px;
                font-weight: bold;
            }

            td:nth-of-type(1)::before { content: "Name"; }
            td:nth-of-type(2)::before { content: "Email"; }
            td:nth-of-type(3)::before { content: "Message"; }
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
    <h2>Contact Messages</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $message): ?>
                <tr>
                    <td><?= htmlspecialchars($message['name']) ?></td>
                    <td><?= htmlspecialchars($message['email']) ?></td>
                    <td><?= nl2br(htmlspecialchars($message['message'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
