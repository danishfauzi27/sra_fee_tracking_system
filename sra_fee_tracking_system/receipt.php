<?php
session_start();
require_once 'connection.php';

// Get receipt number from session
$receipt_number = $_SESSION['receipt_number'] ?? null;

if (!$receipt_number) {
    echo "<p style='color:red;'>Resit tidak dijumpai.</p>";
    exit();
}

// Get payment data
$stmt = $conn->prepare("
    SELECT p.*, s.nama_murid 
    FROM payments p 
    JOIN student s ON p.students_id = s.id 
    WHERE p.receipt_number = ?
");
$stmt->bind_param("s", $receipt_number);
$stmt->execute();
$result = $stmt->get_result();



$payment = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Resit Pembayaran</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .receipt-container {
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(10px);
      max-width: 600px;
      margin: 50px auto;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
    }
    .receipt-container h2 {
      color: #00d4ff;
      margin-bottom: 20px;
    }
    .receipt-container p {
      font-size: 1rem;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<div class="receipt-container">
  <h2>Resit Pembayaran</h2>
  <p><strong>Nama Murid:</strong> <?php echo htmlspecialchars($payment['nama_murid']); ?></p>
  <p><strong>Jumlah Dibayar:</strong> RM <?php echo number_format($payment['amount_paid'], 2); ?></p>
  <p><strong>Nombor Resit:</strong> <?php echo $payment['receipt_number']; ?></p>
  <p><strong>Kaedah Pembayaran:</strong> <?php echo $payment['payment_method']; ?></p>
  <p><strong>Tarikh Pembayaran:</strong> <?php echo date('d/m/Y', strtotime($payment['payment_date'])); ?></p>
  <p><strong>Status:</strong> <?php echo $payment['status'] == 1 ? 'Pending' : 'Approved'; ?></p>

  <div style="margin-top: 30px; display: flex; justify-content: space-between;">
    <a href="parent_dashboard.php" class="btn" style="background:#00d4ff; color:#000; padding:10px 20px; border-radius:10px; text-decoration:none;">← Kembali</a>
    <button onclick="window.print()" class="btn" style="background:#00d4ff; color:#000; padding:10px 20px; border:none; border-radius:10px; cursor:pointer;">🧾 Muat Turun Resit</button>
  </div>
</div>


</body>
</html>
