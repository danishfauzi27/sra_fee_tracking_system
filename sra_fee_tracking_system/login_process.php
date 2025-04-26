<?php
// Start session to track user login
session_start();

// Include database connection
include 'connection.php';

// Get the form data
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare SQL query to fetch user by username
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $user['password'])) {
        // Store session details
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_id'] = $user['id'];

        // Redirect based on numeric role value
        switch ($user['role']) {
            case 1:
                header("Location: admin.php");
                break;
            case 2:
                header("Location: parent_dashboard.php");
                break;
            case 3:
                header("Location: teacher_dashboard.php");
                break;
            default:
                $_SESSION['error'] = "Undefined role!";
                header("Location: login.php");
        }
        exit();
    } else {
        // Wrong password
        $_SESSION['error'] = "Invalid password!";
        header("Location: login.php");
        exit();
    }
} else {
    // User not found
    $_SESSION['error'] = "User not found!";
    header("Location: login.php");
    exit();
}
?>
