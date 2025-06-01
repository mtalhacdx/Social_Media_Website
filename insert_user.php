<?php
include("includes/connection.php");

if (isset($_POST['signup'])) {
    $first_name = htmlentities(mysqli_real_escape_string($con, $_POST['first_name']));
    $last_name = htmlentities(mysqli_real_escape_string($con, $_POST['last_name']));
    $pass = htmlentities(mysqli_real_escape_string($con, $_POST['u_pass']));
    $email = htmlentities(mysqli_real_escape_string($con, $_POST['u_email']));
    $country = htmlentities(mysqli_real_escape_string($con, $_POST['u_country']));
    $gender = htmlentities(mysqli_real_escape_string($con, $_POST['u_gender']));
    $birthday = htmlentities(mysqli_real_escape_string($con, $_POST['u_birthday']));

    $status = "verified";
    $posts = "no";
    $newgid = sprintf('%05d', rand(0, 999999));
    $username = strtolower($first_name . "_" . $last_name . "_" . $newgid);

    

    $check_email = "SELECT * FROM users WHERE user_email = '$email'";
    $run_email = mysqli_query($con, $check_email);
    $check = mysqli_num_rows($run_email);

    if ($check > 0) {
        echo "<script>alert('Email already exists. Please try using a different email.');</script>";
        echo "<script>window.open('signup.php', '_self')</script>";
        exit();
    }

    $rand = rand(1, 3);
    if ($rand == 1)
        $profile_pic = "blue_head.jpg";
    else if ($rand == 2)
        $profile_pic = "vector.jpg";
    else
        $profile_pic = "vector2.png";

    $insert = "INSERT INTO users(f_name, l_name, user_name, describe_user, Relationship, user_pass, user_email, user_country, user_gender, user_birthday, user_image, user_cover, user_reg_date, status, posts, recovery_account)
    VALUES('$first_name', '$last_name', '$username', 'Hello SnapCircle. This is my default status!', '...', '$pass', '$email', '$country','$gender', '$birthday', '$profile_pic', 'profile_cover.jpg', NOW(), '$status', '$posts', 'DreamsDemandDisciplineNotLuck')";

    $query = mysqli_query($con, $insert);

    if ($query) {
        echo "<script>alert('Welcome $first_name, you are good to go');</script>";
        echo "<script>window.open('login.php', '_self')</script>";
    } else {
        echo "<script>alert('Registration failed. Please try again!');</script>";
        echo "Error: " . mysqli_error($con); // Add this for debugging
        echo "<script>window.open('signup.php', '_self')</script>";
    }
    
}
?>
