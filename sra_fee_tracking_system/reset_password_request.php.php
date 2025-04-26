<?php
// Start session to display error messages
session_start();

// Include database connection
include 'connection.php';

// Get the email from the form
$email = $_POST['email'];

// Check if email exists in the database
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  // Send reset password link (this is a placeholder)
  $reset_link = "http://yourdomain.com/reset_password.php?email=" . urlencode($email);
  $_SESSION['success'] = "Reset link telah dihantar ke email anda!";
} else {
  $_SESSION['error'] = "Email tidak dijumpai!";
}

header("Location: forgot_password.php");
exit();
?>
