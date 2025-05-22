<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check all required POST fields
    if (empty($_POST['email'])) {
        die("❌ Email is required.");
    }
    if (empty($_POST['otp'])) {
        die("❌ OTP is required.");
    }
    if (empty($_POST['new_password'])) {
        die("❌ New password is required.");
    }
    if (empty($_POST['confirm_password'])) {
        die("❌ Confirm password is required.");
    }

    // Sanitize inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $entered_otp = mysqli_real_escape_string($conn, $_POST['otp']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($new_password !== $confirm_password) {
        die("❌ Passwords do not match.");
    }

    // Fetch OTP and expiry from database
    $result = mysqli_query($conn, "SELECT otp_code, otp_expiry FROM users WHERE email='$email'");
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $stored_otp = $row['otp_code'];
        $otp_expiry = $row['otp_expiry'];  // <-- Add this line to assign $otp_expiry
        $otp_expiry_timestamp = strtotime($otp_expiry);
        $current_time = time();

        if ($entered_otp === $stored_otp && $current_time <= $otp_expiry_timestamp) {
            // OTP is valid, update password
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $update = mysqli_query($conn, "UPDATE users SET password='$hashed', otp_code=NULL, otp_expiry=NULL WHERE email='$email'");
            if ($update) {
                echo "✅ Password has been successfully updated. <a href='login.html'>Login</a>";
            } else {
                echo "❌ Failed to update password. Try again.";
            }
        } else {
            echo "❌ Invalid or expired OTP.";
        }
    } else {
        echo "❌ Email not found.";
    }
}
?>
