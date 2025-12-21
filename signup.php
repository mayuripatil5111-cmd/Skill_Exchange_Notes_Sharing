<?php include 'includes/connection.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<?php
if (isset($_POST['signup'])) {

  require "gump.class.php";
  $gump = new GUMP();
  $_POST = $gump->sanitize($_POST);

  $gump->validation_rules(array(
    'username' => 'required|alpha_numeric|max_len,20|min_len,4',
    'name'     => 'required|alpha_space|max_len,30|min_len,5',
    'email'    => 'required|valid_email',
    'password' => 'required|max_len,50|min_len,6',
  ));

  $validated_data = $gump->run($_POST);

  if ($validated_data === false) {
    echo "<div class='error'>" . $gump->get_readable_errors(true) . "</div>";
  }
  else if ($_POST['password'] !== $_POST['repassword']) {
    echo "<div class='error'>Passwords do not match</div>";
  }
  else {

    $username = $validated_data['username'];
    $email    = $validated_data['email'];

    $checkuser = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
    $checkmail = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");

    if (mysqli_num_rows($checkuser) > 0) {
      echo "<div class='error'>Username already exists</div>";
    }
    else if (mysqli_num_rows($checkmail) > 0) {
      echo "<div class='error'>Email already exists</div>";
    }
    else {

      $password = password_hash($validated_data['password'], PASSWORD_DEFAULT);

      $query = "INSERT INTO users 
      (username,name,email,password,role,course,gender,joindate,token)
      VALUES (
        '$username',
        '{$validated_data['name']}',
        '$email',
        '$password',
        '{$_POST['role']}',
        '{$_POST['course']}',
        '{$_POST['gender']}',
        '".date("F j, Y")."',
        ''
      )";

      if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registered successfully'); window.location='login.php';</script>";
      } else {
        echo "<div class='error'>Something went wrong</div>";
      }
    }
  }
}
?>

<!-- ================= SIGNUP CARD ================= -->
<div class="signup-card">
  <h2>Create Account</h2>

  <form method="POST">

    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="text" name="username" placeholder="Username" required>

    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="repassword" placeholder="Confirm Password" required>

    <select name="gender" required>
      <option value="">Select Gender</option>
      <option>Male</option>
      <option>Female</option>
    </select>

    <select name="role" required>
      <option value="">I am a</option>
      <option value="teacher">Teacher</option>
      <option value="student">Student</option>
    </select>

    <select name="course" required>
      <option value="">Select Course</option>
      <option>Computer Engineering</option>
      <option>Computer Science & Data Science</option>
      <option>Mechanical Engineering</option>
      <option>Electrical Engineering</option>
      <option>Civil Engineering</option>
      <option>IT Engineering</option>
      <option>AIML Engineering</option>
      <option>AIDS Engineering</option>
    </select>

    <button type="submit" name="signup">Sign Up</button>

  </form>
</div>

</body>
</html>
