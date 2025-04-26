<?php include 'header_teacher.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us - SRA Fee Tracking System</title>
  <link rel="stylesheet" href="aboutus.css"> <!-- Same CSS as homepage -->
  <style>
    .about-container {
      max-width: 900px;
      margin: 50px auto;
      padding: 30px;
      background: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      text-align: left;
    }

    .about-container h2 {
      color: #004080;
      font-size: 2em;
      margin-bottom: 20px;
    }

    .about-container p {
      font-size: 1.1em;
      line-height: 1.8;
      color: #333;
    }

    .about-container ul {
      margin-top: 15px;
      padding-left: 20px;
    }

    .about-container ul li {
      margin-bottom: 10px;
    }

    @media (max-width: 600px) {
      .about-container {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <main>
    <div class="about-container">
      <h2>Tentang Sistem Kami</h2>
      <p>
        SRA Fee Tracking System dibangunkan untuk membantu pengurusan yuran di Sekolah Rendah Agama (SRA) dengan lebih mudah dan teratur.
        Sistem ini membolehkan pihak sekolah untuk merekod dan menjejak pembayaran yuran pelajar dengan lebih efisien.
      </p>

      <p>
        Antara fungsi utama sistem ini termasuk:
      </p>
      <ul>
        <li>Senarai pelajar dan maklumat penjaga</li>
        <li>Rekod yuran yang dikenakan</li>
        <li>Catatan bayaran yang dibuat oleh pelajar</li>
        <li>Penghantaran peringatan bayaran kepada penjaga</li>
      </ul>

      <p>
        Sistem ini dibangunkan oleh pelajar sebagai projek tahun akhir dengan harapan dapat memberi manfaat kepada institusi pendidikan.
      </p>
    </div>
  </main>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> SRA Fee Tracking System</p>
  </footer>

</body>
</html>
