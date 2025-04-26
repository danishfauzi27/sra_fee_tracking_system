<?php
// Start session to allow error messages
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Lupa Katalaluan - SRA Fee Tracking System</title>
  <link rel="stylesheet" href="login.css"> <!-- External CSS -->
</head>
<body>

  <header>
    <h1>SRA Fee Tracking System</h1>
  </header>

  <main>
    <section class="forgot-password-form">
      <br>
      <h2>Lupa Katalaluan</h2>
      <br>
      <br>
      <form action="reset_password_request.php" method="POST">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" placeholder="Masukkan Email Anda" required>
        </div>

        <button type="submit" class="btn">Hantar Reset Link</button>
      </form>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message">
          <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>
    </section>
  </main>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> SRA Fee Tracking System</p>
  </footer>

</body>
</html>
