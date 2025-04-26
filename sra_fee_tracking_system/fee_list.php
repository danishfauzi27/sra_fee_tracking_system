<?php
session_start();
require_once 'connection.php';
include 'admin_header.php'; 

// Add fee for students
if (isset($_POST['add_fee'])) {
    $fee_name = $_POST['fee_name'];
    $fee_amount = $_POST['fee_amount'];
    $due_date = $_POST['due_date'];
    $description = $_POST['description'];

    $query = "INSERT INTO fees (fee_name, amount, due_date, description) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdss", $fee_name, $fee_amount, $due_date, $description);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Yuran berjaya ditambah.";
    } else {
        $_SESSION['error'] = "Gagal tambah yuran.";
    }
}

// Fetch the list of fees
$query = "SELECT fee_id, fee_name, amount, due_date, description FROM fees ORDER BY due_date DESC";
$result = $conn->query($query);
?>

<header>
<h1>Pengurusan Yuran</h1>
</header>

<br><br>

<section class="section">
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <h2>Senarai Yuran</h2>
    <button onclick="document.getElementById('addFeeModal').style.display='block'" class="pay-btn">+ Tambah Yuran</button>
  </div>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="success-message"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  <?php if (isset($_SESSION['error'])): ?>
    <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <table border="1" cellpadding="10" cellspacing="0">
    <thead>
      <tr>
        <th>Nama Yuran</th>
        <th>Jumlah (RM)</th>
        <th>Tarikh Akhir</th>
        <th>Keterangan</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['fee_name']); ?></td>
            <td>RM <?php echo number_format($row['amount'], 2); ?></td>
            <td><?php echo date('d/m/Y', strtotime($row['due_date'])); ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="4" style="text-align:center;">Tiada yuran direkodkan.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</section>

<!-- Modal Form Tambah Yuran -->
<div id="addFeeModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5);">
  <div style="background:white; color:black; max-width:500px; margin:100px auto; padding:30px; border-radius:10px; position:relative;">
    <span onclick="document.getElementById('addFeeModal').style.display='none'" style="position:absolute; top:10px; right:15px; cursor:pointer; font-size:20px;">&times;</span>
    <h2>Tambah Yuran</h2>
    <form method="POST" action="">
      <label for="fee_name">Nama Yuran:</label>
      <input type="text" name="fee_name" required><br><br>

      <label for="fee_amount">Jumlah Yuran (RM):</label>
      <input type="number" step="0.01" name="fee_amount" required><br><br>

      <label for="due_date">Tarikh Akhir Bayaran:</label>
      <input type="date" name="due_date" required><br><br>

      <label for="description">Keterangan:</label>
      <textarea name="description" rows="3" style="width:100%;" required></textarea><br><br>

      <button type="submit" name="add_fee" class="pay-btn">Tambah</button>
    </form>
  </div>
</div>

</body>
</html>