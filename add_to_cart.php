<?php
session_start();
include 'db_connect.php';

// Ensure a valid product ID is passed
if (!isset($_GET['id']) || !isset($_POST['quantity'])) {
    echo "Invalid request.";
    exit();
}

// Fetch the product details based on the product ID
$productId = $_GET['id'];
$quantity = $_POST['quantity'] ?? 1;  // Default quantity is 1 if not provided

$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// If product doesn't exist, show an error
if (!$product) {
    echo "Product not found.";
    exit();
}

// Check if the cart already exists in the session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the product is already in the cart
$productExistsInCart = false;
foreach ($_SESSION['cart'] as $key => $item) {
    if ($item['id'] == $product['id']) {
        $_SESSION['cart'][$key]['quantity'] += $quantity;  // Update quantity
        $productExistsInCart = true;
        break;
    }
}

// If the product is not in the cart, add it
if (!$productExistsInCart) {
    $_SESSION['cart'][] = [
        'id' => $product['id'],
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => $quantity,
        'image_url' => $product['image_url']
    ];
}

// Redirect the user to the product details page or cart page
header("Location: product_details.php?id=$productId");
exit();
?>
