<?php
$conn = new mysqli("localhost", "root", "", "sra_fee_tracking2");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 20");

while ($row = $result->fetch_assoc()) {
    echo "<p><strong>{$row['username']}:</strong> {$row['message']} <span class='time'>{$row['created_at']}</span></p>";
}
?>
x