<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $stmt = $conn->prepare("SELECT name, price, size, description, image_url FROM products WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($product = $result->fetch_assoc()) {
    echo json_encode($product);
  } else {
    echo json_encode(['error' => 'Product not found']);
  }
  $stmt->close();
}
?>
