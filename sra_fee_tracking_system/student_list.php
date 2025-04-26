<?php
session_start();
include 'admin_header.php';
require_once 'connection.php';

// Handle CSV import
if (isset($_POST['upload'])) {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file = $_FILES['file']['tmp_name'];

        if (($handle = fopen($file, "r")) !== FALSE) {
            $rowNum = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $rowNum++;
                if ($rowNum == 1) continue; // Skip header

                if (count($data) < 15) continue; // Skip invalid rows

                // Clean & assign
                $nama_murid = $data[1];
                $no_surat_beranak = $data[2];
                $no_mykid = $data[3];
                $jantina = $data[4];
                $tarikh_lahir = !empty($data[5]) ? date('Y-m-d', strtotime(str_replace(".", "-", $data[5]))) : null;
                $tarikh_masuk = $data[6];
                $sekolah_kebangsaan = $data[7];
                $nama_bapa = $data[8];
                $nama_ibu = $data[9];
                $alamat = $data[10];
                $tel_bapa = $data[11];
                $tel_ibu = $data[12];
                $pekerjaan_bapa = $data[13];
                $pekerjaan_ibu = $data[14];

                $stmt = $conn->prepare("INSERT INTO student (
                    nama_murid, no_surat_beranak, no_mykid, jantina, tarikh_lahir,
                    tarikh_masuk, sekolah_kebangsaan, nama_bapa, nama_ibu, alamat_rumah,
                    no_tel_bapa, no_tel_ibu, pekerjaan_bapa, pekerjaan_ibu
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                if ($stmt) {
                    $stmt->bind_param("ssssssssssssss",
                        $nama_murid, $no_surat_beranak, $no_mykid, $jantina, $tarikh_lahir,
                        $tarikh_masuk, $sekolah_kebangsaan, $nama_bapa, $nama_ibu, $alamat,
                        $tel_bapa, $tel_ibu, $pekerjaan_bapa, $pekerjaan_ibu
                    );
                    $stmt->execute();
                }
            }
            fclose($handle);
            $_SESSION['success'] = "Data CSV berjaya diimport.";
        } else {
            $_SESSION['error'] = "Gagal membaca fail CSV.";
        }
    } else {
        $_SESSION['error'] = "Sila muat naik fail CSV yang sah.";
    }
}

// Fetch students from DB
$result = $conn->query("SELECT * FROM student ORDER BY nama_murid ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Import Murid 3AK</title>
  <link rel="stylesheet" href="student_list.css">
</head>
<body>

<header>
  <h1>Import Murid - Kelas 3AK</h1>
</header>

<main>
  <div class="container">
    <?php if (isset($_SESSION['success'])): ?>
      <div class="success-message"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
      <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <!-- CSV Upload Form -->
    <form method="POST" enctype="multipart/form-data">
      <input type="file" name="file" accept=".csv" required>
      <button type="submit" name="upload">Muat Naik CSV</button>
    </form>

    <br><br>

    <!-- Display Table -->
    <h3>Senarai Murid Kelas 3AK</h3>
    <table>
      <thead>
        <tr>
          <th>Nama Murid</th>
          <th>No. MyKid</th>
          <th>Jantina</th>
          <th>Tarikh Lahir</th>
          <th>Nama Bapa</th>
          <th>No Tel Bapa</th>
          <th>Nama Ibu</th>
          <th>No Tel Ibu</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['nama_murid']); ?></td>
            <td><?php echo $row['no_mykid']; ?></td>
            <td><?php echo $row['jantina']; ?></td>
            <td><?php echo date('d/m/Y', strtotime($row['tarikh_lahir'])); ?></td>
            <td><?php echo htmlspecialchars($row['nama_bapa']); ?></td>
            <td><?php echo $row['no_tel_bapa']; ?></td>
            <td><?php echo htmlspecialchars($row['nama_ibu']); ?></td>
            <td><?php echo $row['no_tel_ibu']; ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<footer>
  <p>&copy; <?php echo date("Y"); ?> SRA Fee Tracking System</p>
</footer>

</body>
</html>
