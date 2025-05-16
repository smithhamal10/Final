<?php 
session_start();
include 'db_connect.php';

// Check admin login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); 
    exit();
}

// Fetch orders with user name
$sql = "SELECT o.id AS order_id, o.user_id, o.total_amount, o.amount, o.status, o.payment_method, 
        o.created_at, o.customer_name, o.customer_email, o.customer_phone, o.delivery_address, 
        o.payment_status, o.transaction_id, u.name AS username
        FROM orders o
        LEFT JOIN users u ON o.user_id = u.id
        ORDER BY o.created_at DESC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL Error: " . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();

// Helper function to display payment method nicely
function formatPaymentMethod($method) {
    switch (strtolower($method)) {
        case 'cod': return 'Cash on Delivery';
        case 'khalti': return 'Khalti';
        default: return ucfirst($method);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Orders - Admin Panel</title>
<style>
    body {
    font-family: Arial, sans-serif;
    padding: 20px;
    background: #f9f9f9;
    color: #333;
}

h1, h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #ff6600;
}

.container {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    justify-content: center;
    max-width: 1200px;
    margin: 0 auto;
}

.table-wrapper {
    flex: 1 1 45%;
    min-width: 320px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgb(0 0 0 / 0.1);
    overflow: hidden;
}

table {
    width: 100%;
    border-collapse: collapse;
    overflow-x: auto;
    display: block;
    max-width: 100%;
}

thead {
    background-color: #ff6600;
    color: white;
}

th, td {
    padding: 12px 15px;
    border-bottom: 1px solid #ddd;
    text-align: left;
    font-size: 14px;
    word-wrap: break-word;
}

tr:hover {
    background-color: #ffe6cc;
    cursor: default;
}

/* Responsive adjustments */
@media (max-width: 900px) {
    .container {
        flex-direction: column;
        padding: 0 10px;
    }
    .table-wrapper {
        flex-basis: 100%;
        min-width: auto;
    }
    table {
        display: block;
        overflow-x: auto;
    }
    th, td {
        white-space: nowrap;
    }
}

/* Small screens, make table rows stack */
@media (max-width: 500px) {
    table, thead, tbody, th, td, tr {
        display: block;
        width: 100%;
    }
    thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
    }
    tr {
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 15px;
        padding: 10px 15px;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    td {
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 50%;
        white-space: normal;
        text-align: left;
    }
    td:before {
        position: absolute;
        top: 12px;
        left: 15px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
        font-weight: bold;
        color: #ff6600;
        content: attr(data-label);
        font-size: 13px;
        text-transform: uppercase;
    }
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
    <h1>Order Management</h1>
    <div class="container">
        <div class="table-wrapper">
            <h2>Order Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Total Amount</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Payment Method</th>
                        <th>Created At</th>
                        <th>Payment Status</th>
                        <th>Transaction ID</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // We'll collect customer info rows in an array for second table
                    $customers = [];
                    while ($row = $result->fetch_assoc()) {
                        // Save customer data keyed by order ID
                        $customers[$row['order_id']] = [
                            'customer_name' => $row['customer_name'],
                            'customer_email' => $row['customer_email'],
                            'customer_phone' => $row['customer_phone'],
                            'delivery_address' => $row['delivery_address'],
                        ];
                        echo "<tr>
                                <td>{$row['order_id']}</td>
                                <td>" . htmlspecialchars($row['username'] ?? 'Guest') . "</td>
                                <td>$" . number_format($row['total_amount'], 2) . "</td>
                                <td>$" . number_format($row['amount'], 2) . "</td>
                                <td>" . htmlspecialchars($row['status']) . "</td>
                                <td>" . formatPaymentMethod($row['payment_method']) . "</td>
                                <td>" . htmlspecialchars($row['created_at']) . "</td>
                                <td>" . htmlspecialchars($row['payment_status']) . "</td>
                                <td>" . htmlspecialchars($row['transaction_id']) . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' style='text-align:center;'>No orders found.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="table-wrapper">
            <h2>Customer Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Customer Phone</th>
                        <th>Delivery Address</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($customers)) {
                    foreach ($customers as $orderId => $cust) {
                        echo "<tr>
                                <td>{$orderId}</td>
                                <td>" . htmlspecialchars($cust['customer_name']) . "</td>
                                <td>" . htmlspecialchars($cust['customer_email']) . "</td>
                                <td>" . htmlspecialchars($cust['customer_phone']) . "</td>
                                <td>" . nl2br(htmlspecialchars($cust['delivery_address'])) . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align:center;'>No customer details available.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
