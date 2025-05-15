<?php
session_start();
header('Content-Type: application/json');

// Ensure the cart exists in the session
if (!isset($_SESSION['cart'])) {
    echo json_encode(["success" => false, "message" => "No cart items found."]);
    exit();
}

if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    // Remove the product from the session cart
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);

        // Recalculate total price after removal
        $totalPrice = 0;
        foreach ($_SESSION['cart'] as $id => $quantity) {
            // Fetch product price (assuming you have product prices already in the session or database)
            // For this, you can store product prices in $_SESSION when adding products to cart
            $price = 100; // Example price (fetch from DB if needed)
            $totalPrice += $price * $quantity;
        }

        echo json_encode(["success" => true, "new_total" => number_format($totalPrice, 2)]);
    } else {
        echo json_encode(["success" => false, "message" => "Item not found in cart."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
