<?php
if (isset($_POST['submit'])) {
  $server = "localhost";
  $username = "root";
  $password = "";
  $database = "home_service";

  $con = mysqli_connect($server, $username, $password, $database);

  if (!$con) {
    die("Connection to database failed: ");
  }

  $uname = $_POST["username"];
  $umail = $_POST["email"];
  $uphone = $_POST["phone"];
  $upw = $_POST["password"];
  $upwc = $_POST["confirm-password"];
  $accCheck = "SELECT * FROM user WHERE email = '$umail' OR phone='$uphone'";
  $result = $con->query($accCheck);
  if ($result->num_rows > 0) {
    echo "Account already exists!";
  } elseif ($upw !== $upwc) {
    echo "The passwords do not match";
  } else if (strlen($uname) < 3) {
    echo "Enter a valid name!";
  } else if (!preg_match('/^(98|97)\d{8}/', $uphone)) {
    echo "Enter a valid phone number!!";
  } else if (strlen($upwc) < 6 || !preg_match('/[A-Z]/', $upwc) || !preg_match('/[0-9]/', $upwc)) {
    echo "Password must be at least 6 characters long, contain at least one capital letter, and at least one number!!";
  } else {
    // Hash the password before storing
    $hpw = password_hash($upw,PASSWORD_DEFAULT);
    $sql = "INSERT INTO  user (username,email,password,phone) VALUES ('$uname', '$umail', '$hpw', '$uphone')"; 
    if ($con->query($sql) === true) {
      echo "Success";
    } else {
      echo "Failure: ";
    }
  }
  $con->close();
}
?>



<!-- backend backend backend backend backend backend backend backend backend backend backend backend backend backend backend backend  -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SkillSprint - Sign Up</title>
  <link rel="stylesheet" href="nav.css">
  <link rel="stylesheet" href="signup.css" />
</head>

<body>
  <!-- ------------------- NAVIGATION BAR ---------------------------- -->
  <nav>
    <div class="logo-container">
      <img src="images/logo/house-cleaning.png" alt="SkillSprint Logo" class="logo" style="z-index: 1" />
    </div>
    <a href="home.html">Home</a>
    <a href="service.html">Services</a>
    <a href="apply.php">Apply as a Worker</a>
    <a href="signin.php">Sign In</a>
    <a href="signout.php">Sign Out</a>

    <div class="profile-icon">
      <img src="images/profile-user.png" alt="profile" class="profile" style="z-index: 1">
    </div>
  </nav>
  <!-- ------------------- NAVIGATION BAR ---------------------------- -->
  <!-- ------------------- SIGN UP FORM ---------------------------- -->
  <div class="signup-container">
    <h1>Sign Up</h1>
    <form action="signup.php" method="post">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="phone">Phone Number:</label>
      <input type="number" id="phone" name="phone" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <label for="confirm-password">Confirm Password:</label>
      <input type="password" id="confirm-password" name="confirm-password" required>

      <button type="submit" name="submit">Sign Up</button>
    </form>

    <p>Already have an account? <a href="signin.php">Sign In</a></p>
  </div>
  <!-- ------------------- SIGN UP FORM ---------------------------- -->


</body>

</html>