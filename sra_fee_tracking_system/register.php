<?php
// Start session to allow error messages
session_start();
$host = "localhost";
$user = "root";
$password = "";
$dbname = "sra_fee_tracking2";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $pass = trim($_POST["password"]);
    $role = trim($_POST["role"]);

    // Validate email uniqueness
    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $error = "Email already exists.";
    } else {
        $hashed = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, is_enabled) VALUES (?, ?, ?, ?, 1)");
        $stmt->bind_param("ssss", $name, $email, $hashed, $role);

        if ($stmt->execute()) {
            $success = "Account created successfully!";
            header("Location: login.php"); // Redirect after success
            exit();
        } else {
            $error = "Registration failed. Try again.";
        }
        $stmt->close();
    }
    $check->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Daftar - SRA Fee Tracking System</title>
  <link rel="stylesheet" href="login.css"> <!-- External CSS -->
</head>
<body>

  <header>
    <h1>SRA Fee Tracking System</h1>
  </header>

  <main>
    <section class="register-form">
     <br>
      <h2>Daftar Akaun Baru</h2>
      <form method="POST" action="register_process.php">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <label for="role">Role:</label>
    <select name="role" required>
        <option value="1">Admin</option>
        <option value="2">Parent</option>
        <option value="3">Teacher</option>
    </select><br>

    <button type="submit">Register</button>
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
