<!DOCTYPE html>
<html>
<head>
  <title>Verify OTP</title>
</head>
<body>
  <h2>Verify OTP and Reset Password</h2>
  <form method="POST" action="otp_verify.php">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="text" name="otp" placeholder="Enter OTP" required><br><br>
    <input type="password" name="new_password" placeholder="New Password" required><br><br>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required><br><br>
    <button type="submit">Submit</button>
  </form>
</body>
</html>
