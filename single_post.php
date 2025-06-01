<!DOCTYPE html>


<?php
session_start();
include("includes/header.php");


// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("location: index.php");
    exit();
}
?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Your Post</title>


    <!-- Bootstrap CSS & JS -->


    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        body {
            overflow-x: hidden;
            /* Prevent horizontal scrolling on the entire page */
        }

        .comment-page-container {
            max-width: 800px;
            width: 100%;
            margin: 30px auto;
            padding: 0 20px;
            box-sizing: border-box;
            /* This ensures padding is included in width calculation */
        }

        .comments-list {
            max-height: 500px;
            overflow-y: auto;
            overflow-x: hidden;
            /* Hide horizontal scrollbar */
            padding-right: 10px;
            width: 100%;
            /* Ensure it takes full width of container */
        }

        /* Ensure all content stays within bounds */
        .post-card,
        .comments-container,
        .comment-form-container {
            width: 100%;
            box-sizing: border-box;
            /* Include padding in width calculation */
        }

        /* Fix for potential image overflow */
        .post-media-image {
            max-width: 100%;
            height: auto;
            display: block;
            /* Removes extra space below images */
        }

        /* Main Container */
        .comment-page-container {
            max-width: 800px;
            width: 100%;
            margin: 30px auto;
            padding: 0 20px;
            box-sizing: border-box;
        }

        /* Post Card Styles */
        .post-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            overflow: hidden;
        }

        .post-content {
            padding: 25px;
        }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .post-user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 2px solid rgba(67, 97, 238, 0.1);
        }

        .post-meta {
            display: flex;
            flex-direction: column;
        }

        .post-username {
            margin: 0 0 5px 0;
            font-size: 1.1rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .post-timestamp {
            color: #6c757d;
            font-size: 0.85rem;
        }

        .post-text-content {
            color: #333;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .post-text-content p {
            margin: 0 0 15px 0;
        }

        .post-image-container {
            text-align: center;
            margin: 20px 0;
        }

        .post-media-image {
            max-width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .post-image-missing {
            background: #fff3cd;
            color: #856404;
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 0.9rem;
            text-align: center;
        }

        /* Comments Section */
        .comments-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            padding: 25px;
        }

        .comments-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding-bottom: 15px;
        }

        .comments-title {
            margin: 0;
            font-size: 1.1rem;
            color: #2c3e50;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .comments-title::before {
            content: "";
            display: inline-block;
            width: 24px;
            height: 24px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%234361ee'%3E%3Cpath d='M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
            margin-right: 10px;
        }

        .comments-count {
            background-color: #4361ee;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .comments-list {
            max-height: 500px;
            overflow-y: auto;
            padding-right: 10px;
        }

        /* Comment Form */
        .comment-form-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.08);
            padding: 25px;
        }

        .comment-form-title {
            margin: 0 0 20px 0;
            font-size: 1.1rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .comment-input-container {
            position: relative;
            margin-bottom: 20px;
        }

        .comment-textarea {
            width: 100%;
            min-height: 120px;
            padding: 15px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            resize: vertical;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }

        .comment-textarea:focus {
            outline: none;
            border-color: #4361ee;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .comment-label {
            position: absolute;
            top: 15px;
            left: 15px;
            color: #6c757d;
            pointer-events: none;
            transition: all 0.2s ease;
            background: white;
            padding: 0 5px;
        }

        .comment-textarea:focus+.comment-label,
        .comment-textarea:not(:placeholder-shown)+.comment-label {
            top: -10px;
            left: 10px;
            font-size: 0.8rem;
            color: #4361ee;
        }

        .comment-submit-container {
            text-align: right;
        }

        .comment-submit-button {
            background-color: #4361ee;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
        }

        .comment-submit-button::before {
            content: "";
            display: inline-block;
            width: 18px;
            height: 18px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M2.01 21L23 12 2.01 3 2 10l15 2-15 2z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
            margin-right: 8px;
        }

        .comment-submit-button:hover {
            background-color: #3a56d4;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(67, 97, 238, 0.2);
        }

        .comment-submit-button:active {
            transform: translateY(0);
        }

        /* Comment Items (from fetch_comments.php) */
        .comment-item {
            background-color: #f9f9f9;
            border-left: 3px solid #4361ee;
            border-radius: 0 8px 8px 0;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.2s ease;
        }

        .comment-item:hover {
            background-color: #f0f4ff;
        }

        .comment-author-container {
            display: flex;
            margin-bottom: 10px;
        }

        .comment-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 2px solid rgba(67, 97, 238, 0.1);
        }

        .comment-meta {
            flex: 1;
        }

        .comment-author {
            margin: 0;
            font-size: 1rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .comment-date {
            color: #6c757d;
            font-size: 0.8rem;
            margin-top: 3px;
        }

        .comment-text {
            margin: 0;
            color: #333;
            line-height: 1.5;
        }

        /* Custom Scrollbar */
        .comments-list::-webkit-scrollbar {
            width: 6px;
        }

        .comments-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .comments-list::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .comments-list::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .comment-page-container {
                padding: 0 15px;
            }

            .post-content,
            .comments-container,
            .comment-form-container {
                padding: 20px;
            }

            .post-user-avatar {
                width: 50px;
                height: 50px;
            }

            .comment-avatar {
                width: 40px;
                height: 40px;
            }
        }

        @media (max-width: 480px) {

            .post-header,
            .comment-author-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .post-user-avatar,
            .comment-avatar {
                margin-right: 0;
                margin-bottom: 10px;
            }

            .comments-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .comments-count {
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>

    <div class="row">
        <div class="col-sm-12">
            <center>
                <h2>Comments</h2>
            </center>

            <?php single_post(); ?>
        </div>
    </div>




    <script>
        $(document).ready(function() {
            // Load comments
            function loadComments() {
                let postId = $('#postId').val();
                $.get("fetch_comments.php", {
                    post_id: postId
                }, function(data) {
                    $('#comments-container').html(data);
                });
            }

            loadComments(); // initial load
            setInterval(loadComments, 5000); // refresh every 5 seconds

            // Submit comment form
            $('#commentForm').submit(function(e) {
                e.preventDefault();
                let comment = $('#commentText').val();
                let postId = $('#postId').val();

                if (comment.trim() === '') {
                    alert("Please write something!");
                    return;
                }

                $.post("add_comment.php", {
                    comment: comment,
                    post_id: postId
                }, function(response) {
                    $('#commentText').val('');
                    loadComments(); // reload comments after posting
                }).fail(function(xhr) {
                    alert("Failed: " + xhr.responseText);
                });
            });
        });
    </script>

</body>

</html>