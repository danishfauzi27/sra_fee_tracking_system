<?php
// Start session to allow error messages
session_start();

// Get the email from the URL (for simplicity)
$email = $_GET['email'] ?? '';

// If email is not provided, redirect to forgot password page
if (empty($email)) {
  header("Location: forgot_password.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Katalaluan - SRA Fee Tracking System</title>
  <link rel="stylesheet" href="login.css"> <!-- External CSS -->
</head>
<body>

  <header>
    <h1>SRA Fee Tracking System</h1>
  </header>

  <main>
    <section class="reset-password-form">
      <h2>Reset Katalaluan</h2>
      <form action="reset_password_process.php" method="POST">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

        <div class="form-group">
          <label for="new_password">Katalaluan Baru</label>
          <input type="password" name="new_password" id="new_password" placeholder="Masukkan Katalaluan Baru" required>
        </div>

        <button type="submit" class="btn">Kemas Kini Katalaluan</button>
      </form>
    </section>
  </main>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> SRA Fee Tracking System</p>
  </footer>

</body>
</html>
