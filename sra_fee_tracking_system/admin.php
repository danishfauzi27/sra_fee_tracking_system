<?php
// Start session
session_start();
include 'admin_header.php'; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SRA Fee Tracking System - Admin Dashboard</title>
  <link rel="stylesheet" href="admin.css"> <!-- External CSS -->
</head>
<body>


  <main>
    <section class="welcome">
      <h2>Selamat Datang!</h2>
      <p>Sistem ini membantu mengurus dan menjejak bayaran yuran pelajar Sekolah Rendah Agama (SRA).</p>
    </section>

    <section class="admin-dashboard">
      <div class="card">
        <h3>Jumlah Pelajar</h3>
        <p>10</p> <!-- Example number of students, can be dynamic -->
      </div>

      <div class="card">
        <h3>Jumlah Yuran</h3>
        <p>RM 1,500</p> <!-- Example total fees, can be dynamic -->
      </div>

      <div class="card">
        <h3>Jumlah Bayaran</h3>
        <p>RM 1,200</p> <!-- Example total payments, can be dynamic -->
      </div>

      <div class="card">
        <h3>Jumlah Tunggakan</h3>
        <p>RM 300</p> <!-- Example outstanding balance, can be dynamic -->
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> SRA Fee Tracking System</p>
  </footer>

</body>
</html>
