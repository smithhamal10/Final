<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];
$conn->query("DELETE FROM products WHERE id=$id");

header("Location: admin_dashboard.php");
exit();
?>
