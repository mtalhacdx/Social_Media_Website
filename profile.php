<?php
session_start();
include("includes/header.php");

// Redirect if not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}

// Get logged in user's data with prepared statement
$user_email = $_SESSION['user_email'];
$get_user = "SELECT * FROM users WHERE user_email = ?";
$stmt = mysqli_prepare($con, $get_user);
mysqli_stmt_bind_param($stmt, "s", $user_email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($result);

if (!$row) {
    // User not found in database
    session_destroy();
    header("Location: index.php");
    exit();
}

$logged_in_user_id = $row['user_id'];
$logged_in_user_email = $row['user_email'];

// Get profile user data (either logged in user or someone else)
$profile_user_id = isset($_GET['u_id']) ? (int)$_GET['u_id'] : $logged_in_user_id;

// Validate profile user exists
$get_profile = "SELECT * FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($con, $get_profile);
mysqli_stmt_bind_param($stmt, "i", $profile_user_id);
mysqli_stmt_execute($stmt);
$profile_result = mysqli_stmt_get_result($stmt);
$profile = mysqli_fetch_array($profile_result);

if (!$profile) {
    echo "<script>alert('User profile not found!')</script>";
    echo "<script>window.open('home.php', '_self')</script>";
    exit();
}

// Assign profile data with null checks
$user_name = htmlspecialchars($profile['user_name'] ?? '');
$first_name = htmlspecialchars($profile['f_name'] ?? '');
$last_name = htmlspecialchars($profile['l_name'] ?? '');
$describe_user = htmlspecialchars($profile['describe_user'] ?? '');
$Relationship = htmlspecialchars($profile['Relationship'] ?? 'Not specified');
$user_country = htmlspecialchars($profile['user_country'] ?? 'Not specified');
$register_date = htmlspecialchars($profile['user_reg_date'] ?? '');
$user_gender = htmlspecialchars($profile['user_gender'] ?? 'Not specified');
$user_birthday = htmlspecialchars($profile['user_birthday'] ?? 'Not specified');
$user_image = htmlspecialchars($profile['user_image'] ?? 'default.png');
$user_cover = htmlspecialchars($profile['user_cover'] ?? 'default_cover.jpg');

// Check if viewing own profile
$is_own_profile = ($profile_user_id == $logged_in_user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $user_name; ?> | Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

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

        .row {
            margin-right: 0;
            margin-left: 0;
        }

        /* Cover Section */
        .cover-container {
            position: relative;
            margin-bottom: 100px;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }

        #cover-img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            transition: var(--transition);
        }

        .cover-actions {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        /* Profile Section */
        .profile-section {
            position: relative;
            padding: 0 20px;
        }

        .profile-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-top: -100px;
            z-index: 2;
            position: relative;
        }

        .profile-image-container {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid white;
            box-shadow: var(--box-shadow);
            overflow: hidden;
            margin-bottom: 20px;
            position: relative;
            transition: var(--transition);
        }

        .profile-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-name {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--dark-color);
        }

        .profile-bio {
            font-size: 16px;
            color: var(--gray-color);
            margin-bottom: 20px;
            max-width: 600px;
            font-style: italic;
        }

        /* Main Content Layout */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .content-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        /* About Card */
        .about-card {
            background-color: white;
            padding: 25px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            flex: 1;
            height: 570px;
            min-width: 300px;
            transition: var(--transition);
        }

        .about-card h2 {
            font-size: 22px;
            margin-bottom: 20px;
            color: var(--dark-color);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding-bottom: 10px;
            position: relative;
        }

        .about-card h2:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 3px;
        }

        .about-info {
            margin-bottom: 15px;
            padding: 12px 15px;
            border-left: 3px solid var(--primary-color);
            background-color: var(--light-color);
            border-radius: 6px;
            transition: var(--transition);
        }

        .about-info:hover {
            background-color: #e9ecef;
        }

        .about-info strong {
            color: var(--gray-color);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
            display: block;
        }

        .about-info span {
            font-weight: 500;
            color: var(--dark-color);
            font-size: 1rem;
        }

        /* Edit Profile Button */
        .btn-edit {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 30px;
            color: white;
            padding: 10px 20px;
            font-weight: 500;
            letter-spacing: 0.5px;
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
            transition: var(--transition);
            width: 100%;
            max-width: 200px;
            display: inline-block;
            text-align: center;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Posts Section */
        .posts-section {
            flex: 2;
            min-width: 300px;
        }

        .section-title {
            position: relative;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 600;
            color: var(--dark-color);
        }

        .section-title:after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 3px;
        }

        .post-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 25px;
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .post-header {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .post-user-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 2px solid white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .post-user-info {
            flex-grow: 1;
        }

        .post-user-name {
            font-weight: 600;
            margin-bottom: 0;
            color: var(--dark-color);
        }

        .post-user-name a {
            color: inherit;
            text-decoration: none;
            transition: var(--transition);
        }

        .post-user-name a:hover {
            color: var(--primary-color);
        }

        .post-date {
            color: var(--gray-color);
            font-size: 0.8em;
        }

        .post-content {
            padding: 15px;
            line-height: 1.7;
            color: #495057;
        }

    .post-image {
    max-width: 100%;
    max-height: 500px;
    border-radius: 8px;
    margin: 15px auto;
    display: block;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

        /* Post Action Buttons */
        .post-actions {
            display: flex;
            gap: 20px;
            padding: 12px 15px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            justify-content: flex-start;
            align-items: center;
        }

        .post-action {
            color: #555;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .post-action i {
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .post-action:hover {
            color: #4361ee;
        }

        .post-action:hover i {
            transform: scale(1.1);
        }

        .delete-action:hover {
            color: #f44336 !important;
        }

        /* Active state for buttons */
        .post-action:active {
            opacity: 0.7;
        }

        /* No Posts Style */
        .no-posts {
            text-align: center;
            padding: 40px 20px;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 25px;
        }

        .no-posts-icon {
            font-size: 60px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .no-posts h3 {
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .no-posts p {
            color: var(--gray-color);
            max-width: 400px;
            margin: 0 auto;
        }

        /* Edit Button Styles */
        .profile-edit-button {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.6);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            outline: none;
        }

        .profile-image-container:hover .profile-edit-button {
            opacity: 1;
        }

        /* Cover Edit Button Styles */
        .cover-edit-button {
            background: rgba(0, 0, 0, 0.6);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            opacity: 1;
            transition: var(--transition);
            cursor: pointer;
            z-index: 2;
            border: none;
            outline: none;
        }

        .cover-edit-button:hover,
        .profile-edit-button:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        /* File Input Hidden */
        .hidden-file-input {
            display: none !important;
        }

        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .profile-content {
                margin-top: -80px;
            }

            .profile-image-container {
                width: 130px;
                height: 130px;
            }

            .profile-name {
                font-size: 24px;
            }

            #cover-img {
                height: 300px;
            }
        }

        @media (max-width: 992px) {
            .profile-content {
                margin-top: -80px;
            }

            .profile-image-container {
                width: 110px;
                height: 110px;
            }

            .about-info {
                padding: 10px 12px;
            }

            .profile-name {
                font-size: 22px;
            }

            #cover-img {
                height: 280px;
            }
        }

        @media (max-width: 768px) {
            body {
                margin-top: 10px;
            }

            .content-row {
                flex-direction: column;
            }

            .profile-content {
                margin-top: -60px;
            }

            .profile-image-container {
                width: 100px;
                height: 100px;
                border-width: 3px;
            }

            .profile-name {
                font-size: 20px;
            }

            #cover-img {
                height: 250px;
            }

            .cover-actions {
                top: 10px;
                right: 10px;
            }

            .about-card,
            .posts-section {
                min-width: 100%;
            }
        }

        @media (max-width: 576px) {
            body {
                margin-top: 10px;
            }

            .profile-content {
                margin-top: -50px;
            }

            .profile-image-container {
                width: 80px;
                height: 80px;
            }

            .profile-name {
                font-size: 18px;
            }

            .profile-bio {
                font-size: 14px;
            }

            #cover-img {
                height: 200px;
            }

            .cover-container {
                margin-bottom: 70px;
            }

            .about-info strong {
                font-size: 0.75rem;
            }

            .about-info span {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <div class="main-content">
        <!-- Cover and Profile Section -->
        <div class="cover-container">
            <img id="cover-img" src="cover/<?= $user_cover; ?>" alt="Cover Image" onerror="this.src='cover/default_cover.jpg'">

            <?php if ($is_own_profile): ?>
                <div class="cover-actions">
                    <form id="cover-form" action="profile.php?u_id=<?= $profile_user_id; ?>" method="post" enctype="multipart/form-data">
                        <label for="cover-upload" class="cover-edit-button" title="Change Cover Photo">
                            <i class="fas fa-pencil-alt"></i>
                        </label>
                        <input id="cover-upload" type="file" name="u_cover" class="hidden-file-input" accept="image/*" onchange="this.form.submit()">
                    </form>
                </div>
            <?php endif; ?>

            <div class="profile-section">
                <div class="profile-content">
                    <div class="profile-image-container">
                        <img src="users/<?= $user_image; ?>" alt="Profile Image" onerror="this.src='users/default.png'">

                        <?php if ($is_own_profile): ?>
                            <form id="profile-form" action="profile.php?u_id=<?= $profile_user_id; ?>" method="post" enctype="multipart/form-data">
                                <label for="profile-upload" class="edit-button profile-edit-button" title="Change Profile Photo">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input id="profile-upload" type="file" name="u_image" class="hidden-file-input" accept="image/*" onchange="this.form.submit()">
                            </form>
                        <?php endif; ?>
                    </div>

                    <h1 class="profile-name"><?= "$first_name $last_name"; ?></h1>
                    <p class="profile-bio"><?= $describe_user; ?></p>
                </div>
            </div>
        </div>

        <!-- User Info and Posts -->
        <div class="content-row">
            <!-- About Section -->
            <div class="about-card">
                <h2>About</h2>
                <div class="about-info">
                    <strong>Relationship</strong>
                    <span><?= $Relationship; ?></span>
                </div>
                <div class="about-info">
                    <strong>Lives In</strong>
                    <span><?= $user_country; ?></span>
                </div>
                <div class="about-info">
                    <strong>Member Since</strong>
                    <span><?= $register_date; ?></span>
                </div>
                <div class="about-info">
                    <strong>Gender</strong>
                    <span><?= $user_gender; ?></span>
                </div>
                <div class="about-info">
                    <strong>Birth Date</strong>
                    <span><?= $user_birthday; ?></span>
                </div>

                <?php if ($is_own_profile): ?>
                    <center>
                        <a href='edit_profile.php?u_id=<?= $profile_user_id; ?>' class='btn btn-edit btn-block'>
                            <i class='fas fa-user-edit'></i> Edit Profile
                        </a>
                    </center>
                <?php endif; ?>
            </div>

            <!-- Posts Section -->
            <div class="posts-section">
                <h2 class="section-title"><?= "$first_name $last_name"; ?>'s Posts</h2>
                
                <?php
                // Handle image uploads
                if ($is_own_profile) {
                    if (isset($_FILES['u_cover'])) {
                        $u_cover = $_FILES['u_cover']['name'];
                        $tmp_name = $_FILES['u_cover']['tmp_name'];
                        $file_ext = pathinfo($u_cover, PATHINFO_EXTENSION);
                        $new_cover = "cover/" . time() . "_" . uniqid() . ".$file_ext";

                        if (move_uploaded_file($tmp_name, $new_cover)) {
                            $update_cover = "UPDATE users SET user_cover=? WHERE user_id=?";
                            $stmt = mysqli_prepare($con, $update_cover);
                            mysqli_stmt_bind_param($stmt, "si", basename($new_cover), $profile_user_id);
                            mysqli_stmt_execute($stmt);
                            echo "<script>window.location.href='profile.php?u_id=$profile_user_id';</script>";
                        }
                    }

                    if (isset($_FILES['u_image'])) {
                        $u_image = $_FILES['u_image']['name'];
                        $tmp_name = $_FILES['u_image']['tmp_name'];
                        $file_ext = pathinfo($u_image, PATHINFO_EXTENSION);
                        $new_image = "users/" . time() . "_" . uniqid() . ".$file_ext";

                        if (move_uploaded_file($tmp_name, $new_image)) {
                            $update_image = "UPDATE users SET user_image=? WHERE user_id=?";
                            $stmt = mysqli_prepare($con, $update_image);
                            mysqli_stmt_bind_param($stmt, "si", basename($new_image), $profile_user_id);
                            mysqli_stmt_execute($stmt);
                            echo "<script>window.location.href='profile.php?u_id=$profile_user_id';</script>";
                        }
                    }
                }

                // Display posts
                $get_posts = "SELECT * FROM posts WHERE user_id = ? ORDER BY post_date DESC LIMIT 5";
                $stmt = mysqli_prepare($con, $get_posts);
                mysqli_stmt_bind_param($stmt, "i", $profile_user_id);
                mysqli_stmt_execute($stmt);
                $run_posts = mysqli_stmt_get_result($stmt);
                $post_count = mysqli_num_rows($run_posts);

                if ($post_count == 0) {
                    echo "<div class='no-posts'>
                            <i class='far fa-newspaper no-posts-icon'></i>
                            <h3>No posts yet</h3>
                            <p>Stay connected with $first_name — exciting updates are on the way!</p>
                          </div>";
                } else {
                    while ($post = mysqli_fetch_assoc($run_posts)) {
                        $post_id = $post['post_id'];
                        $content = htmlspecialchars($post['post_content']);
                        $upload_image = htmlspecialchars($post['upload_image']);
                        $post_date = htmlspecialchars($post['post_date']);

                        echo "
                        <div class='post-card'>
                            <div class='post-header'>
                                <img src='users/$user_image' class='post-user-img' alt='User' onerror=\"this.src='users/default.png'\">
                                <div class='post-user-info'>
                                    <div class='post-user-name'><a href='user_profile.php?u_id=$profile_user_id'>$user_name</a></div>
                                    <div class='post-date'>Posted on $post_date</div>
                                </div>
                            </div>
                            <div class='post-content'>";

                        if ($upload_image && $content == 'No') {
                            echo "<img src='PostImage/$upload_image' class='post-image' onerror=\"this.style.display='none'\">";
                        } elseif ($content != 'No') {
                            echo "<p class='post-text'>$content</p>";
                            if ($upload_image) {
                                echo "<img src='PostImage/$upload_image' class='post-image' onerror=\"this.style.display='none'\">";
                            }
                        }

                        echo "</div>";

                        // Only show action buttons if it's the user's own profile
                        if ($is_own_profile) {
                            echo "
                            <div class='post-actions'>
                                <a href='single_post.php?post_id=$post_id' class='post-action' title='View Post'>
                                    <i class='far fa-eye'></i> View
                                </a>
                                <a href='edit_post.php?post_id=$post_id' class='post-action' title='Edit Post'>
                                    <i class='far fa-edit'></i> Edit
                                </a>
                                <a href='Functions/delete_post.php?post_id=$post_id' class='post-action delete-action' title='Delete Post' onclick=\"return confirm('Are you sure you want to delete this post?');\">
                                    <i class='far fa-trash-alt'></i> Delete
                                </a>
                            </div>";
                        }

                        echo "</div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>