<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {

    include "../connect.php";

    $cid = $_POST['change_id'];
    $cusername = $_POST['change_username'];
    $cemail = $_POST['change_email'];
    $cphone = $_POST['change_phone'];
    $cpassword = $_POST['change_password'];

    $query = "UPDATE users SET username='$cusername', email='$cemail', phone='$cphone', password='$cpassword' WHERE id=$cid";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "Details updated successfully.";
        header("refresh:2;url=users.php");
        exit;
    } else {
        echo "Error updating details: " . mysqli_error($con);
    }

    mysqli_close($con);
} elseif (isset($_POST['cancel'])) {
    header("Location: users.php");
    exit;
}
