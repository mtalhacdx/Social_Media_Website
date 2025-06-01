<?php
include("Includes/connection.php");

if (!isset($_GET['post_id'])) {
    echo "<div class='text-center py-4 text-muted'>No Post ID</div>";
    exit();
}

$post_id = intval($_GET['post_id']);
$run_com = mysqli_query($con, "SELECT * FROM comments WHERE post_id = '$post_id' ORDER BY 1 DESC");

if (mysqli_num_rows($run_com) == 0) {
    echo "<div class='text-center py-4 text-muted no-comments'>No comments yet. Be the first to comment!</div>";
    exit();
}

while ($row = mysqli_fetch_array($run_com)) {
    $com = htmlspecialchars($row['comment']);
    $com_name = htmlspecialchars($row['comment_author']);
    $date = date('F j, Y \a\t g:i a', strtotime($row['date']));

    $user_result = mysqli_query($con, "SELECT user_image FROM users WHERE user_name = '$com_name'");
    $user_data = mysqli_fetch_assoc($user_result);
    $user_image = $user_data['user_image'] ?? 'default.jpg';

   echo "
<div class='comment-item'>
    <div class='d-flex'>
        <img src='users/$user_image' class='rounded-circle me-3 comment-avatar' width='48' height='48' style='object-fit: cover;'>
        <div class='flex-grow-1'>
            <div class='d-flex justify-content-between align-items-center mb-2'>
                <h6 class='mb-0 comment-author'>$com_name</h6>
                <small class='comment-date'>$date</small>
            </div>
            <p class='mb-0 comment-text'>$com</p>
        </div>
    </div>
</div>";
}
?>