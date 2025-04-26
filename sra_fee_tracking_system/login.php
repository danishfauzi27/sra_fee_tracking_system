<?php
// Start session to allow login functionality
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "sra_fee_tracking2";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $pass = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND is_enabled = 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($pass, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_role"] = strtolower($user["role"]); // Normalize case
            $_SESSION["user_name"] = $user["name"];

            // Role-based redirection (case-insensitive)
            $role = $_SESSION["user_role"];
            if ($role === "admin") {
                header("Location: admin.php");
            } elseif ($role === "teacher") {
                header("Location: teacher_dashboard.php");
            } else {
                header("Location: parent_dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found or disabled.";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - SRA Fee Tracking System</title>
  <link rel="stylesheet" href="login.css"> <!-- External CSS -->
</head>
<body>

  <header>
    <h1>SRA Fee Tracking System</h1>
  </header>
  <br>
  <br>
 
  <main>
    <section class="login-form">
    <br>

      <h2>Log Masuk</h2>
      <br>
      <form action="login_process.php" method="POST">
        <div class="form-group">
          <label for="username">Nama Pengguna</label>
          <input type="text" name="username" id="username" placeholder="Masukkan Nama Pengguna" required>
        </div>

        <div class="form-group">
          <label for="password">Katalaluan</label>
          <input type="password" name="password" id="password" placeholder="Masukkan Katalaluan" required>
        </div>

        <button type="submit" class="btn">Log Masuk</button>
      </form>

      <!-- Display error message if there is one -->
      <?php if (!empty($_SESSION['error'])): ?>
        <div class="error-message">
          <?php 
            echo $_SESSION['error']; 
            unset($_SESSION['error']); // Clear the error message after displaying
          ?>
        </div>
      <?php endif; ?>

      <div class="auth-links">
        <p><a href="forgot_password.php">Lupa Katalaluan?</a></p>
        <p>Belum ada akaun? <a href="register.php">Daftar Sekarang</a></p>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> SRA Fee Tracking System</p>
  </footer>

</body>
</html>
