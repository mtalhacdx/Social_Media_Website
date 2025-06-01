<?php
session_start();
include("includes/connection.php"); // Make sure this connects to your DB

if (!isset($_SESSION['user_email'])) {
    http_response_code(403);
    echo "Login required";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = intval($_POST['post_id']);
    $comment = trim($_POST['comment']);

    if (empty($comment)) {
        http_response_code(400);
        echo "Comment cannot be empty";
        exit();
    }

    // Get user info
    $user_email = $_SESSION['user_email'];
    $user_result = mysqli_query($con, "SELECT * FROM users WHERE user_email = '$user_email'");
    $user = mysqli_fetch_assoc($user_result);

    $user_id = $user['user_id'];
    $user_name = $user['user_name'];

    $insert = "INSERT INTO comments (post_id, user_id, comment, comment_author, date)
               VALUES ('$post_id', '$user_id', '$comment', '$user_name', NOW())";

    if (mysqli_query($con, $insert)) {
        echo "Comment added successfully";
    } else {
        http_response_code(500);
        echo "Failed to insert comment";
    }
}
?>
