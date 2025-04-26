<?php
include 'connection.php';

// Optional: session check untuk admin login
// session_start();
// if (!isset($_SESSION['admin'])) {
//   header("Location: login.php");
//   exit();
//}

$result = mysqli_query($conn, "SELECT * FROM feedback ORDER BY submitted_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Lihat Maklum Balas - SRA Fee Tracking System</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .feedback-list-container {
      max-width: 1000px;
      margin: 50px auto;
      padding: 30px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h2 {
      color: #004080;
      margin-bottom: 20px;
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table th, table td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: left;
    }

    table th {
      background: #004080;
      color: white;
    }

    tr:nth-child(even) {
      background: #f2f2f2;
    }

    .no-feedback {
      text-align: center;
      font-style: italic;
      color: #777;
    }
  </style>
</head>
<body>

  <header>
    <h1>SRA Fee Tracking System</h1>
    <nav>
      <ul>
        <li><a href="index.php">Utama</a></li>
        <li><a href="student_list.php">Senarai Pelajar</a></li>
        <li><a href="fee_list.php">Senarai Yuran</a></li>
        <li><a href="payment_list.php">Rekod Bayaran</a></li>
        <li><a href="feedback.php">Maklum Balas</a></li>
        <li><a href="view_feedback.php">Lihat Feedback</a></li>
        <li><a href="login.php">Log Masuk</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <div class="feedback-list-container">
      <h2>Senarai Maklum Balas</h2>

      <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Mesej</th>
            <th>Tarikh</th>
          </tr>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['name']); ?></td>
              <td><?php echo htmlspecialchars($row['email']); ?></td>
              <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
              <td><?php echo $row['submitted_at']; ?></td>
            </tr>
          <?php endwhile; ?>
        </table>
      <?php else: ?>
        <p class="no-feedback">Tiada maklum balas diterima setakat ini.</p>
      <?php endif; ?>
    </div>
  </main>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> SRA Fee Tracking System</p>
  </footer>

</body>
</html>
