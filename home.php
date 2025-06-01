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

// Get user data
$user_email = $_SESSION['user_email'];
$get_user_query = "SELECT * FROM users WHERE user_email = ?";
$stmt = mysqli_prepare($con, $get_user_query);
mysqli_stmt_bind_param($stmt, "s", $user_email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['user_id'];
    $user_name = $row['user_name'];
} else {
    echo "<h3>Error: User not found.</h3>";
    exit();
}
?>
<html>

<head>
    <title><?php echo htmlspecialchars($user_name); ?></title>
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
    <div class="main-content">
       <!-- Post Input Section -->
<div class="post-input-container">
    <form action="home.php?id=<?php echo urlencode($user_id); ?>" method="post" id="f">
        <div class="post-input-box">
            <div class="post-avatar">
                <img src="users/<?php echo htmlspecialchars($row['user_image'] ?? 'vector2.png'); ?>" alt="User">
            </div>
            <div class="post-input">
                <input
                    type="text"
                    id="post"
                    name="content"
                    placeholder="What's on your mind?"
                    required>
            </div>
            <div class="post-button">
                <button type="submit" name="sub"><i class="fa fa-share-square" aria-hidden="true"></i> Post</button>
            </div>
        </div>
    </form>
</div>
        <!-- News Feed Title -->
        <div class="news-feed-title">News Feed</div>

        <!-- Posts Container -->
        <div class="posts-container">
            <?php
            if (function_exists('get_posts')) {
                echo get_posts();
            } else {
                echo "<p>Error: get_posts() function not found.</p>";
            }
            ?>
        </div>
    </div>
</body>

</html>