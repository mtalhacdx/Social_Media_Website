<?php
session_start();
include("includes/header.php");

if (!isset($_SESSION['user_email'])) {
    header("location: index.php");
    exit();
}

$post_con = '';
$get_id = isset($_GET['post_id']) ? $_GET['post_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>

    <!-- Bootstrap CSS & JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #6c757d;
            --border-radius: 12px;
            --box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7ff;
            color: var(--dark-color);
            line-height: 1.6;
            padding-top: 70px;
        }

        .edit-post-container {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 30px;
            margin: 30px 0;
            transition: var(--transition);
        }

        .edit-post-container:hover {
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .edit-post-title {
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 15px;
        }

        .edit-post-title:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 3px;
        }

        .edit-post-textarea {
            width: 100%;
            min-height: 200px;
            padding: 15px;
            border-radius: var(--border-radius);
            border: 1px solid rgba(0, 0, 0, 0.1);
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            margin-bottom: 25px;
            transition: var(--transition);
        }

        .edit-post-textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.16);
            outline: none;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .edit-post-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: var(--border-radius);
            padding: 12px 25px;
            font-weight: 500;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .edit-post-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.4);
            color: white;
        }

        .cancel-btn {
            background-color: white;
            color: var(--gray-color);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: var(--border-radius);
            padding: 12px 25px;
            font-weight: 500;
            transition: var(--transition);
        }

        .cancel-btn:hover {
            background-color: var(--light-color);
            color: var(--dark-color);
            transform: translateY(-2px);
        }

        .edit-post-alert {
            margin-top: 20px;
            border-radius: var(--border-radius);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .edit-post-container {
                padding: 25px;
            }
            
            .edit-post-title {
                font-size: 22px;
            }
            
            .button-group {
                flex-direction: column;
                gap: 10px;
            }
            
            .edit-post-btn, .cancel-btn {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .edit-post-container {
                padding: 20px;
            }
            
            .edit-post-title {
                font-size: 20px;
            }
            
            .edit-post-textarea {
                min-height: 150px;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-2 col-md-3"></div>
            <div class="col-xs-12 col-sm-8 col-md-6">
                <div class="edit-post-container">
                    <?php
                    if (isset($get_id)) {
                        $get_post = "SELECT * FROM posts WHERE post_id = '$get_id'";
                        $run_post = mysqli_query($con, $get_post);
                        
                        if ($run_post && mysqli_num_rows($run_post) > 0) {
                            $row = mysqli_fetch_array($run_post);
                            $post_con = $row['post_content'];
                        } else {
                            echo "<div class='alert alert-danger edit-post-alert'>Post not found!</div>";
                            exit();
                        }
                    } else {
                        echo "<div class='alert alert-danger edit-post-alert'>No post ID specified!</div>";
                        exit();
                    }
                    ?>

                    <form action="" method="post" id="edit_post_form">
                        <h2 class="edit-post-title">Edit Your Post</h2>
                        <textarea class="form-control edit-post-textarea" name="content" required><?php echo htmlspecialchars($post_con); ?></textarea>
                        <input type="hidden" name="post_id" value="<?php echo $get_id; ?>">
                        
                        <div class="button-group">
                            <button type="submit" name="update" class="btn edit-post-btn">
                                <i class="fas fa-pencil-alt"></i> Update Post
                            </button>
                            <a href="home.php" class="btn cancel-btn">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST['update'])) {
                        $content = mysqli_real_escape_string($con, $_POST['content']);
                        $post_id = mysqli_real_escape_string($con, $_POST['post_id']);
                        
                        $update_post = "UPDATE posts SET post_content = '$content' WHERE post_id = '$post_id'";
                        $run_update = mysqli_query($con, $update_post);
                        
                        if ($run_update) {
                            echo "<script>alert('Post has been successfully updated!')</script>";
                            echo "<script>window.open('home.php', '_self')</script>";
                            exit();
                        } else {
                            echo "<div class='alert alert-danger edit-post-alert'>Error updating post: " . mysqli_error($con) . "</div>";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-2 col-md-3"></div>
        </div>
    </div>
</body>
</html>