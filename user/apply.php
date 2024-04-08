  <?php
  if (isset($_POST['submit'])) {
    include_once "../connect.php";
    $wname = $_POST["name"];
    $wmail = $_POST["email"];
    $wphone = $_POST["phone"];
    $wskill = $_POST["skills"];
    $warea = $_POST['service_area'];
    $wphoto = $_FILES['photo']['name'];
    $wphoto_temp = $_FILES['photo']['tmp_name'];
    $wphoto_folder = '../images/wphoto/' . $wphoto;
    $wc = $_FILES['certificate']['name'];
    $wc_temp = $_FILES['certificate']['tmp_name'];
    $wc_folder = '../images/wcerti/' . $wc;
    $accCheck = "SELECT * FROM workers WHERE email = '$wmail' OR phone='$wphone'";
    $result = $con->query($accCheck);
    if (empty($wname) || empty($wmail) || empty($wphone) || empty($wskill) || empty($warea) || empty($wphoto) || empty($wc)){
      echo "One or more required fields are empty, Please fill in all the fields.";
    }else{
    if ($result->num_rows > 0) {
      echo "Account already exists!";
    } else if ($wskill == "Select a skill") {
      echo "Select a skill!!";
    } else if (strlen($wname) < 3 || strlen($wname) > 20 || !preg_match('/^[a-zA-Z][a-zA-Z\s]*[a-zA-Z]$/', $wname)) {
      echo "Enter a valid name!";
    }else if (!preg_match('/^(98|97)\d{8}$/', $wphone)) {
      echo "Enter a valid phone number!!";
    }else if ($wskill==null) {
      echo "Choose a skill type!";
    }else if (!preg_match('/^[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $wmail)) {
      echo "Invalid email format!  ";
    } else if (strlen($warea) < 5 || strlen($warea)>30) {
      echo "Enter a valid working area!!";
    }else if ($wphoto==null) {
      echo "Choose a photo!!";
    }else if ($wc==null) {
      echo "Choose a certificate!!";
    } else {
      $sql = "INSERT INTO applications (name, phone, email, skill, service_area, photo, certificate) VALUES ('$wname', '$wphone', '$wmail', '$wskill', '$warea', '$wphoto', '$wc')";
      if ($con->query($sql) === true) {
        move_uploaded_file($wphoto_temp, $wphoto_folder);
        move_uploaded_file($wc_temp, $wc_folder);
        echo "Success";
      } else {
        echo "Failure: ";
      }
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
    <title>SkillSprint</title>
    <link rel="stylesheet" href="nav.css" />
    <link rel="stylesheet" href="apply.css" />
  </head>

  <body>
  <!-- ------------------- NAVIGATION BAR ---------------------------- -->
  <nav >
    <div class='logo-container'>
      <img src='../images\logo\house-cleaning.png' alt='SkillSprint Logo' class='logo' style='z-index: 1' />
    </div>
    <a href='home.php' class='hovers'>Home</a>
    <a href='service.php' class='hovers'>Services</a>
    <a href='apply.php' class='hovers'>Apply as a Worker</a>
    <a href='signin.php' class='hovers'>Sign In</a>
  </nav>
  <!-- ------------------- NAVIGATION BAR ---------------------------- -->

  
      <div class="apply-container">
      <h1>Apply as Skill Worker</h1>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" >

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" >

        <label for="phone">Phone Number:</label>
        <input type="number" id="phone" name="phone" >

        <label for="skills">Skills:</label>
        <select id="skills" name="skills">
          <option value="">Select a skill</option>
          <option value="Plumber">Plumber</option>
          <option value="Electrician">Electrician</option>
          <option value="Interior_design">Interior Design</option>
          <option value="Painter">Painter</option>
          <option value="Carpenter">Carpenter</option>
        </select>

        <label for="service_area">Service Area:</label>
        <input type="text" id="service_area" name="service_area">

        <label for="photo">Upload Photo:</label>
        <input type="file" id="photo" name="photo" accept=".jpg, .jpeg">

        <label for="certificate">Upload Certificate:</label>
        <input type="file" id="certificate" name="certificate" accept=".pdf,.png, .jpg, .jpeg">

        <button type="submit" name="submit" onmouseover="change(this)" onmouseout="unchange(this)">Submit Application</button>
      </form>
    </div>

    <script>
      function change(element) {
        element.style.backgroundColor = "white";
        element.style.color = "#333";
      }

      function unchange(element) {
        element.style.backgroundColor = "#333";
        element.style.color = "white";
      }
    </script>
  </body>

  </html>