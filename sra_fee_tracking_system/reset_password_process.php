<?php
// Start session to allow error messages
session_start();

// Include database connection
include 'connection.php';

// Get form data
$email = $_POST['email'];
$new_password = $_POST['new_password'];

// Hash the new password
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Update password in the database
$sql = "UPDATE users SET password = ? WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $hashed_password, $email);
$stmt->execute();

// Redirect to login page with success message
$_SESSION['success'] = "Katalaluan berjaya dikemaskini!";
header("Location: login.php");
exit();
?>
