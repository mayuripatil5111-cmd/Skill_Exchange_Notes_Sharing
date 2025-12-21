<?php
include 'includes/connection.php';
include 'includes/header.php';
include 'includes/navbar.php';

session_start();

if (isset($_POST['login'])) {

  $username = mysqli_real_escape_string($conn, $_POST['user']);
  $password = $_POST['pass'];

  $query = "SELECT * FROM users WHERE username = '$username'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {

    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {

      $_SESSION['id'] = $row['id'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['name'] = $row['name'];
      $_SESSION['email'] = $row['email'];
      $_SESSION['role'] = $row['role'];
      $_SESSION['course'] = $row['course'];

      header("Location: dashboard/");
      exit;

    } else {
      echo "<script>alert('Invalid password');</script>";
    }

  } else {
    echo "<script>alert('Username not found');</script>";
  }
}
?>

<!-- LOGIN CARD -->
<div class="login-card">
  <h1>Login</h1>

  <form method="POST">
    <input type="text" name="user" placeholder="Username" required>

    <div class="password-box">
      <input type="password" name="pass" id="password" placeholder="Password" required>
      <span class="toggle-eye" onclick="togglePassword()">👁</span>
    </div>

    <input type="submit" name="login" class="login-submit" value="Login">
  </form>
</div>

<!-- PASSWORD TOGGLE SCRIPT -->
<script>
function togglePassword() {
  const pass = document.getElementById("password");
  pass.type = pass.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
