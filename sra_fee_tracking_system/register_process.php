<?php
session_start();
include 'connection.php';

// Get data from form
$username = $_POST['username'];
$password = $_POST['password'];

// Check if username already exists
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['error'] = "Nama Pengguna telah digunakan!";
    header("Location: register.php");
    exit();
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into users table
$sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}

// Set default role (example: parent = 2)
$role = 2;

$stmt->bind_param("ssi", $username, $hashed_password, $role); // ssi: 2 strings, 1 integer
$stmt->execute();

// Redirect to login
header("Location: login.php");
exit();
?>
