<?php
session_start();
include("includes/connection.php");

if (isset($_POST['login'])) {

    $email = htmlentities(mysqli_real_escape_string($con, $_POST['email']));

    $pass = htmlentities(mysqli_real_escape_string($con, $_POST['pass']));

    $select_user = "SELECT * FROM users WHERE user_email = '$email' AND user_pass = '$pass' AND status = 'verified'";

    $query = mysqli_query($con, $select_user);

    $check_user = mysqli_num_rows($query);

    if($check_user == 1){
        $_SESSION['user_email'] = $email;
        echo "<script>window.open('profile.php', '_self')</script>";  
    }
    else{
        echo "<script>alert('Your emai or password is incorrect')</script>";
        
    }
}
?>