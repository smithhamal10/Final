<?php
include('db_connect.php');  // Include the MySQLi connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form input values
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    

    // SQL query to insert form data into the contact_messages table
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the statement
        $stmt->bind_param("sss", $name, $email, $message);

        // Execute the statement
        if ($stmt->execute()) {
            // If insertion is successful, show success message and redirect
            echo "<script>alert('Message sent successfully!'); window.location.href='contact.php';</script>";
        } else {
            // If there is an error during insertion, show error message
            echo "<script>alert('Error sending message. Please try again.'); window.location.href='contact.php';</script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        // If the statement couldn't be prepared, show an error
        echo "<script>alert('Error preparing statement.'); window.location.href='contact.php';</script>";
    }
}

// Close the connection
$conn->close();
?>
