<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: grey
; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 50px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center;">
        
        <!-- Thank You Image -->
        <img src="https://imgs.search.brave.com/1j-OEHrMnYgi21XW-1ChrE514cUFWDKrNgq_5NngaRA/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly9kMWNz/YXJrejhvYmU5dS5j/bG91ZGZyb250Lm5l/dC9wb3N0ZXJwcmV2/aWV3cy90aGFuay15/b3UtdGVtcGxhdGUt/ZGVzaWduLTAyODA0/YjA5ZjIxYWI4MzZm/MWFmODM2YWNhZmI4/ZTA3LmpwZz90cz0x/Njc2MjAyNDYw" alt="Thank You" style="max-width: 200px; margin-bottom: 20px;">
        
        <h2 style="color: #333;">Subscription Status</h2>
        
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo '<p style="color: red;">Invalid email address.</p>';
            } else {
                // Database connection
                $conn = new mysqli("localhost", "root", "", "smith");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Prevent duplicate subscriptions
                $checkQuery = "SELECT * FROM subscribers WHERE email = ?";
                $stmt = $conn->prepare($checkQuery);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo '<p style="color: #f39c12;">You\'re already subscribed!</p>';
                } else {
                    $insertQuery = "INSERT INTO subscribers (email) VALUES (?)";
                    $stmt = $conn->prepare($insertQuery);
                    $stmt->bind_param("s", $email);

                    if ($stmt->execute()) {
                        echo '<p style="color: orange;">Thanks for subscribing!</p>';
                    } else {
                        echo '<p style="color: red;">Something went wrong. Please try again.</p>';
                    }
                }

                $stmt->close();
                $conn->close();
            }
        }
        ?>

        <a href="home.php" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #4CAF50; color: #fff; text-decoration: none; border-radius: 4px;">Go Back to Home</a>
    </div>
</body>
</html>
