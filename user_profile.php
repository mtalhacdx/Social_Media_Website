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
<html>

<head>
    <title>Find People</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS & JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="Custom-CSS/user_profile.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php
            if (isset($_GET['u_id'])) {
                $u_id = $_GET['u_id'];
            }

            if ($u_id < 0 || $u_id == "") {
                echo "<script>window.open('home.php','_self')</script>";
            } else {
                // Get user info first
                global $con;
                $user_id = $_GET['u_id'];
                $select = "SELECT * FROM users WHERE user_id = '$user_id'";
                $run = mysqli_query($con, $select);
                $row = mysqli_fetch_array($run);

                $id = $row['user_id'];
                $image = $row['user_image'];
                $name = $row['user_name'];
                $f_name = $row['f_name'];
                $l_name = $row['l_name'];
                $describe_user = $row['describe_user'];
                $country = $row['user_country'];
                $gender = $row['user_gender'];
                $register_date = $row['user_reg_date'];
            ?>

                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1"></div>
                        <div class="col-xs-12 col-sm-10 col-md-3 col-lg-3">
                            <div class="profile-container">
                                <div class="profile-header">
                                    <h3>Profile Information</h3>
                                </div>
                                <?php
                                $profile_img_path = "users/" . $image;
                                if (file_exists($profile_img_path)) {
                                    echo "<center><img class='profile-img' src='$profile_img_path'></center>";
                                } else {
                                    echo "<center><img class='profile-img' src='users/default.jpg'></center>";
                                }
                                ?>
                                
                                <div class="profile-info">
                                    <div class="info-item">
                                        <div class="info-label">Name</div>
                                        <div class="info-value"><?php echo "$f_name $l_name"; ?></div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <div class="info-label">Status</div>
                                        <div class="info-value"><?php echo $describe_user; ?></div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <div class="info-label">Gender</div>
                                        <div class="info-value"><?php echo $gender; ?></div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <div class="info-label">Country</div>
                                        <div class="info-value"><?php echo $country; ?></div>
                                    </div>
                                    
                                    <div class="info-item">
                                        <div class="info-label">Member Since</div>
                                        <div class="info-value"><?php echo $register_date; ?></div>
                                    </div>
                                </div>

                                <?php
                                $user = $_SESSION['user_email'];
                                $get_user = "SELECT * FROM users WHERE user_email = '$user'";
                                $run_user = mysqli_query($con, $get_user);
                                $row_user = mysqli_fetch_array($run_user);

                                $userown_id = $row_user['user_id'];

                                if ($user_id == $userown_id) {
                                    echo "<center><a href='edit_profile.php?u_id=$userown_id' class='btn btn-edit btn-block'>Edit Profile</a></center>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-10 col-md-7 col-lg-7">
                            <div class="posts-container">
                                <h2 class="section-title"><?php echo "$f_name $l_name"; ?>'s Posts</h2>

                                <div id="posts-container">
                                    <?php
                                    $get_posts = "SELECT * FROM posts WHERE user_id = '$u_id' ORDER BY 1 DESC LIMIT 5";
                                    $run_posts = mysqli_query($con, $get_posts);

                                    $post_count = mysqli_num_rows($run_posts);

                                    if ($post_count == 0) {
                                        echo "<div class='no-posts'>
                                                <i class='far fa-newspaper no-posts-icon'></i>
                                                <h3>No posts yet</h3>
                                                <p>Stay connected with $f_name — exciting updates are on the way!</p>
                                              </div>";
                                    } else {
                                        while ($row_posts = mysqli_fetch_array($run_posts)) {
                                            $post_id = $row_posts['post_id'];
                                            $content = $row_posts['post_content'];
                                            $upload_image = $row_posts['upload_image'];
                                            $post_date = $row_posts['post_date'];

                                            $formatted_date = date("F j, Y, g:i a", strtotime($post_date));

                                            echo "
                                            <div class='post-card'>
                                                <div class='post-header'>";

                                            // Profile picture
                                            $user_img_path = "users/" . $user_image;
                                            if (file_exists($user_img_path)) {
                                                echo "<img src='$user_img_path' class='post-user-img'>";
                                            } else {
                                                echo "<img src='users/default.jpg' class='post-user-img'>";
                                            }

                                            echo "
                                                    <div class='post-user-info'>
                                                        <h4 class='post-user-name'>$f_name $l_name</h4>
                                                        <span class='post-date'>$formatted_date</span>
                                                    </div>
                                                </div>";

                                            if ($content != "No") {
                                                echo "<div class='post-content'>$content</div>";
                                            }

                                            if (!empty($upload_image) && $upload_image != "No") {
                                                $post_img = "PostImage/$upload_image";
                                                if (file_exists($post_img)) {
                                                    echo "<img src='$post_img' class='post-image'>";
                                                } else {
                                                    echo " Image not found at $post_img ";
                                                }
                                            }

                                            echo "
                                                <div class='post-actions'>
                                                    <a href='single_post.php?post_id=$post_id#comments' class='post-action'>
                                                        <i class='far fa-comment'></i> Comment
                                                    </a>
                                                </div>
                                            </div>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1"></div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>