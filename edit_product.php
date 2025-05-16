<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['category'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];

    $conn->query("UPDATE products SET name='$name', description='$desc', price='$price', image_url='$image_url' WHERE id=$id");
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            padding: 40px;
            display: flex;
            justify-content: center;
        }

        .edit-form-container {
            background: white;
            padding: 30px;
            max-width: 600px;
            width: 100%;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .edit-form-container h2 {
            margin-bottom: 20px;
            color: #343a40;
            text-align: center;
        }

        form label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #495057;
        }

        form input[type="text"],
        form input[type="number"],
        form textarea {
            width: 100%;
            padding: 10px 14px;
            margin-top: 6px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 16px;
            transition: border 0.3s;
        }

        form input:focus,
        form textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        .image-preview {
            margin-top: 20px;
            text-align: center;
        }

        .image-preview img {
            width: 100%;
            max-height: 300px;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .image-preview img:hover {
            transform: scale(1.02);
        }

        form button {
            margin-top: 25px;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        form button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .edit-form-container {
                padding: 20px;
            }

            form button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="edit-form-container">
        <h2>Edit Product</h2>
        <form method="post">
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

            <label>Category:</label>
            <textarea name="category" required><?= htmlspecialchars($product['category']) ?></textarea>

            <label>Price:</label>
            <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" required>

            <label>Image URL:</label>
            <input type="text" name="image_url" id="image_url" value="<?= htmlspecialchars($product['image_url']) ?>" required oninput="updateImagePreview()">

            <div class="image-preview">
                <img id="productImage" src="<?= htmlspecialchars($product['image_url']) ?>" alt="Product Image">
            </div>

            <button type="submit">Update Product</button>
        </form>
    </div>

    <script>
        function updateImagePreview() {
            const imageUrl = document.getElementById('image_url').value;
            const img = document.getElementById('productImage');
            img.src = imageUrl;
        }
    </script>
</body>
</html>
