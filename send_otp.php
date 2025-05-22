<?php
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';
include 'db_connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $userCheck = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($userCheck) > 0) {
        $otp = rand(100000, 999999);
        $expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        mysqli_query($conn, "UPDATE users SET otp_code='$otp', otp_expiry='$expiry' WHERE email='$email'");

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'smithhamal001@gmail.com';
            $mail->Password   = 'briapobwnzhyglst';  // 16-digit App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('smithhamal001@gmail.com', 'SwooshX Support');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body    = "<p>Your OTP code is: <strong>$otp</strong></p><p>This code is valid for 5 minutes.</p>";

            $mail->send();
            echo "✅ OTP has been sent to your email.";
        } catch (Exception $e) {
            echo "❌ OTP could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "❌ No account found with that email.";
    }
}
?>
