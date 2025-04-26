<?php
session_start();
require_once 'connection.php';
include 'header.php';

// Fetch all students
$students = $conn->query("SELECT id, nama_murid FROM student");

// Fetch all fees
$fees = $conn->query("SELECT fee_id, fee_name, amount, description FROM fees");
$fees_data = [];
while ($fee = $fees->fetch_assoc()) {
    $fees_data[$fee['fee_id']] = $fee; // store for later use in JavaScript
}
?>

<br><br>
<section class="section">
  <h2>Bayar Yuran</h2>
  <p>Sila lengkapkan maklumat berikut untuk membuat bayaran yuran:</p>

  <form action="payment.php" method="POST">
    <!-- Select Student -->
    <label for="students_id">Nama Murid:</label>
    <select name="students_id" id="students_id" required>
      <option value="">-- Pilih Murid --</option>
      <?php while ($student = $students->fetch_assoc()): ?>
        <option value="<?php echo $student['id']; ?>"><?php echo htmlspecialchars($student['nama_murid']); ?></option>
      <?php endwhile; ?>
    </select>

    <br><br>

    <!-- Select Fee -->
    <label for="fee_id">Yuran:</label>
    <select name="fee_id" id="fee_id" required onchange="updateFeeDetails()">
      <option value="">-- Pilih Yuran --</option>
      <?php foreach ($fees_data as $id => $fee): ?>
        <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($fee['fee_name']); ?></option>
      <?php endforeach; ?>
    </select>

    <br><br>

    <!-- Auto-filled Amount -->
    <label for="amount">Jumlah (RM):</label>
    <input type="text" id="amount" name="amount" readonly>

    <br><br>

    <!-- Auto-filled Description -->
    <label for="description">Keterangan:</label>
    <textarea id="description" name="description" rows="4" readonly></textarea>

    <br><br>
    <button type="submit" class="pay-btn">Bayar Yuran</button>
  </form>
</section>

<script>
  const feeDetails = <?php echo json_encode($fees_data); ?>;

  function updateFeeDetails() {
    const selectedFeeId = document.getElementById('fee_id').value;
    if (feeDetails[selectedFeeId]) {
      document.getElementById('amount').value = feeDetails[selectedFeeId].amount;
      document.getElementById('description').value = feeDetails[selectedFeeId].description;
    } else {
      document.getElementById('amount').value = '';
      document.getElementById('description').value = '';
    }
  }
</script>

</body>
</html>
