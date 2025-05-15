<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php include 'nav.php'; ?>

<div style="max-width: 600px; margin: 100px auto; padding: 40px; border: 2px solid #4CAF50; border-radius: 10px; background-color: #f9fff9; text-align: center;">
    <img src="https://cdn-icons-png.flaticon.com/512/845/845646.png" alt="Success" style="width: 100px; margin-bottom: 20px;">
    <h2 style="color: #4CAF50;">Order Placed Successfully!</h2>
    <p style="font-size: 18px; color: #333;">Thank you for your purchase. Your order has been placed and is being processed.</p>
    <a href="home.php" style="display: inline-block; margin-top: 20px; padding: 12px 25px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 6px;">Go to Home</a>
</div>

<?php include 'footer.php'; ?>
