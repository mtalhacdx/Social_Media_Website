<!DOCTYPE html>
<?php
session_start();
include("includes/header.php");

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("location: index.php");
    exit(); // Always exit after header redirect
}

// DB connection must be present
global $con;

?>
<html>

<head>
    <title>My Posts</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS & JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   
    <!-- Custom CSS -->
    <link rel="stylesheet" href="Custom-CSS/home.css?v=1.0">

  
</head>

<body>
   <div class="row">
    <div class="col-sm-12">
        <center>
        <h2>Your Latest Posts</h2>
        </center>
        <?php user_posts();?>
    </div>
   </div>
</body>

</html>