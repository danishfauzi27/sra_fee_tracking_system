<?php
session_start();
include 'admin_header.php';
require_once 'connection.php';

// Fetch payment records with student name
$query = "
    SELECT p.payment_id, s.nama_murid, p.students_id, p.fee_id, 
           p.amount_paid, p.payment_date, p.payment_method, p.status 
    FROM payments p
    JOIN student s ON p.students_id = s.id
    ORDER BY p.payment_date DESC
";
$result = $conn->query($query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment List - Admin</title>
    <link rel="stylesheet" href="student_list.css"> <!-- Reuse the same CSS file -->
</head>
<body>
    <br>
    <br>
    <!-- <header> -->
        <h1>Rekod Bayaran</h1>
        <br>

    <main>
        <div class="container">
        <h3>Senarai Pembayaran</h3>

<table>
  <thead>
    <tr>
      <th>ID Pembayaran</th>
      <th>Nama Murid</th>
      <th>ID Murid</th>
      <th>ID Yuran</th>
      <th>Jumlah (RM)</th>
      <th>Tarikh Bayaran</th>
      <th>Kaedah</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['payment_id']; ?></td>
          <td><?php echo htmlspecialchars($row['nama_murid']); ?></td>
          <td><?php echo $row['students_id']; ?></td>
          <td><?php echo $row['fee_id']; ?></td>
          <td><?php echo number_format($row['amount_paid'], 2); ?></td>
          <td><?php echo date('d/m/Y', strtotime($row['payment_date'])); ?></td>
          <td><?php echo $row['payment_method']; ?></td>
          <td><?php echo $row['status'] == 1 ? 'Paid' : 'Approved'; ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="8" style="text-align:center;">Tiada rekod bayaran ditemui.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> SRA Fee Tracking System</p>
    </footer>

</body>
</html>
