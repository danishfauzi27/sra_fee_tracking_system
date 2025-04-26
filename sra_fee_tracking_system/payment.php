<?php
session_start();
require_once 'connection.php';

// Get values from previous form
$students_id = $_POST['students_id'] ?? null;
$fee_id = $_POST['fee_id'] ?? null;
$amount = $_POST['amount'] ?? null;

// Generate receipt number (e.g. REC202404102301)
$receipt_number = "REC" . date("YmdHis");

// Insert on form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pay_now'])) {
    $method = $_POST['payment_method'];
    $payment_date = date("Y-m-d");
    $status = 1; // Pending

    $stmt = $conn->prepare("INSERT INTO payments 
        (students_id, fee_id, status, payment_date, amount_paid, receipt_number, payment_method)
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("iiisdss", $students_id, $fee_id, $status, $payment_date, $amount, $receipt_number, $method);

    if ($stmt->execute()) {
        $_SESSION['receipt_number'] = $receipt_number; // Pass to receipt.php
        header("Location: receipt.php");
        exit();
    } else {
        echo "<p style='color:red;'>Gagal menyimpan bayaran: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pengesahan Bayaran</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <h1>Pengesahan Bayaran</h1>
</header>

<main class="section">
  <form method="POST">
    <input type="text" name="students_id" value="<?php echo htmlspecialchars($students_id); ?>">
    <input type="text" name="fee_id" value="<?php echo htmlspecialchars($fee_id); ?>">
    <input type="text" name="amount" value="<?php echo htmlspecialchars($amount); ?>">

    <p><strong>Jumlah Yuran:</strong> RM <?php echo number_format($amount, 2); ?></p>

    <label for="payment_method">Kaedah Pembayaran:</label>
    <select name="payment_method" id="payment_method" required>
      <option value="">-- Pilih Kaedah --</option>
      <option value="Tunai">Tunai</option>
      <option value="Bank Transfer">Bank Transfer</option>
      <option value="Online">Online</option>
    </select>

    <br><br>
    <button type="submit" name="pay_now" class="pay-btn">Bayar Sekarang</button>
  </form>
</main>

</body>
</html>
