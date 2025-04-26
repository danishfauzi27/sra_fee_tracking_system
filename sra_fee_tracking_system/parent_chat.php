<?php
session_start();
include 'header.php'; 

$conn = new mysqli("localhost", "root", "", "sra_fee_tracking2");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get current user info
$username = $_SESSION['username'] ?? 'Guest';
$role = $_SESSION['user_role'] ?? 'student';

// Insert message
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $message = $conn->real_escape_string($_POST['message']);
    $stmt = $conn->prepare("INSERT INTO messages (username, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $message);
    $stmt->execute();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat - Sekolah Kebangsaan Binjai</title>
    <link rel="stylesheet" href="parent_chat.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Video Background
<div class="video-container">
    <video autoplay muted loop id="bgVideo">
        <source src="bg.mp4" type="video/mp4">
    </video>
</div> -->


<!-- Chat Box -->
<div class="chat-container">
    <h2>Live Chat - SRA Usamah Bin Zaid</h2>
    <div class="chat-box" id="chatBox">
        <?php
        $res = $conn->query("
        SELECT m.*, u.role 
        FROM messages m
        LEFT JOIN users u ON m.username = u.username
        ORDER BY m.created_at ASC
      ");
      
      while ($row = $res->fetch_assoc()) {
        $alignClass = ($row['username'] === $username) ? 'me' : 'them';
    
        // Convert numeric role to text for color class
        switch ($row['role']) {
            case 1: $roleClass = 'admin'; break;
            case 2: $roleClass = 'parent'; break;
            case 3: $roleClass = 'teacher'; break;
            default: $roleClass = 'unknown';
        }
    
        echo "<div class='bubble $roleClass $alignClass'>
                <strong>{$row['username']}</strong>: {$row['message']}
                <span class='time'>{$row['created_at']}</span>
              </div>";
    }
    
        ?>
    </div>

    <form method="POST" class="chat-form">
        <input type="text" name="message" placeholder="Type your message..." required>
        <button type="submit">Send</button>
    </form>
</div>

<footer>&copy; <?= date("Y") ?> Sekolah Kebangsaan Binjai. All rights reserved.</footer>
</body>
</html>
