<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "social_network") or die("Connection was not established");

// Function to insert a new post
function insertPost()
{
    global $con, $user_id;

    // Check if user is logged in
    if (!isset($user_id) || !$user_id) return;

    // Check if the form is submitted
    if (isset($_POST['sub'])) {

        // Validate content
        $content = mysqli_real_escape_string($con, htmlentities($_POST['content'] ?? ''));
        $upload_image = $_FILES['upload_image']['name'] ?? '';
        $image_tmp = $_FILES['upload_image']['tmp_name'] ?? '';
        $random_number = rand(1, 100);
        $image_name = "";

        // Check if image folder exists
        if (!file_exists("PostImage")) {
            if (!mkdir("PostImage", 0777, true)) {
                echo "<script>alert('Failed to create image directory.')</script>";
                return;
            }
        }

        // Check content length
        if (strlen($content) > 250) {
            echo "<script>alert('Please use 250 or less than 250 characters!')</script>";
            echo "<script>window.open('home.php', '_self')</script>";
            return;
        }

        // Process image upload
        if (!empty($upload_image)) {
            $image_name = $random_number . "_" . basename($upload_image);
            if (!move_uploaded_file($image_tmp, "PostImage/$image_name")) {
                echo "<script>alert('Failed to upload image. Check folder permissions.')</script>";
                return;
            }
        }

        // Validate input
        if (empty($content) && empty($upload_image)) {
            echo "<script>alert('Post content or image is required!')</script>";
            echo "<script>window.open('home.php', '_self')</script>";
            return;
        }

        // Default content if missing
        if (empty($content)) {
            $content = "No content";
        }

        // Insert post into database
        $insert = "INSERT INTO posts (user_id, post_content, upload_image, post_date) 
                   VALUES ('$user_id', '$content', '$image_name', NOW())";
        $run = mysqli_query($con, $insert);

        if (!$run) {
            echo "<script>alert('Error: " . mysqli_error($con) . "')</script>";
            return;
        }

        echo "<script>alert('Your post has been published!')</script>";
        echo "<script>window.open('home.php', '_self')</script>";

        // Update user's status
        $update = "UPDATE users SET posts='yes' WHERE user_id='$user_id'";
        mysqli_query($con, $update);
    }
}

// Function to fetch and display posts
function get_posts()
{
    global $con;
    $per_page = 4;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start_from = ($page - 1) * $per_page;

    $get_posts = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $start_from, $per_page";
    $run_posts = mysqli_query($con, $get_posts);

    if (!$run_posts) {
        die("Post fetch error: " . mysqli_error($con));
    }

    $total_posts = mysqli_num_rows($run_posts);

    // Start posts container
    echo "<div class='posts-container'>";

    if ($total_posts == 0) {
        // No posts found - show the "no posts" message
        echo "<div class='no-posts'>
                <i class='far fa-newspaper no-posts-icon'></i>
                <h3>No posts yet</h3>
                <p>Be the first to share something with the community!</p>
              </div>";
    } else {
        // Display posts
        while ($row_posts = mysqli_fetch_assoc($run_posts)) {
            $post_id = $row_posts['post_id'];
            $user_id = $row_posts['user_id'];
            $content = $row_posts['post_content'];
            $upload_image = $row_posts['upload_image'];
            $post_date = $row_posts['post_date'];

            $user_query = "SELECT * FROM users WHERE user_id='$user_id'";
            $run_user = mysqli_query($con, $user_query);

            if (!$run_user || mysqli_num_rows($run_user) === 0) continue;

            $row_user = mysqli_fetch_assoc($run_user);
            $user_name = $row_user['user_name'];
            $user_image = $row_user['user_image'];
            $f_name = $row_user['f_name'];
            $l_name = $row_user['l_name'];

            // Format the date nicely
            $formatted_date = date("F j, Y, g:i a", strtotime($post_date));

            echo "
            <div class='post-card'>
                <div class='post-header'>
                    <a href='user_profile.php?u_id=$user_id'>
                        <img src='users/$user_image' alt='$user_name' class='post-user-img'>
                    </a>
                    <div class='post-user-info'>
                        <h4 class='post-user-name'>
                            <a href='user_profile.php?u_id=$user_id'>$f_name $l_name</a>
                        </h4>
                        <span class='post-date'>$formatted_date</span>
                    </div>
                </div>";

            if ($content !== "No content") {
                echo "<div class='post-content'>$content</div>";
            }

            if (!empty($upload_image)) {
                $image_path = "PostImage/$upload_image";
                if (file_exists($image_path)) {
                    echo "<div class='post-image-container'>
                            <img src='$image_path' class='post-image' alt='Post Image'>
                          </div>";
                } else {
                    echo "<div class='alert alert-warning'>Image not found</div>";
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

    // Close posts container
    echo "</div>";

    // Only show pagination if there are posts
    if ($total_posts > 0) {
        include("pagination.php");
    }
}

function single_post(){
    if (isset($_GET['post_id'])) {
        global $con;
        $get_id = mysqli_real_escape_string($con, $_GET['post_id']);

        $get_posts = "SELECT * FROM posts WHERE post_id = '$get_id'";
        $run_posts = mysqli_query($con, $get_posts);

        if (!$run_posts || mysqli_num_rows($run_posts) === 0) {
            echo "<script>alert('Post not found')</script>";
            echo "<script>window.open('home.php', '_self')</script>";
            return;
        }

        $row_posts = mysqli_fetch_assoc($run_posts);
        $post_id = $row_posts['post_id'];
        $user_id = $row_posts['user_id'];
        $content = $row_posts['post_content'];
        $upload_image = $row_posts['upload_image'];
        $post_date = $row_posts['post_date'];

        $user = "SELECT * FROM users WHERE user_id = '$user_id' AND posts = 'yes'";
        $run_user = mysqli_query($con, $user);

        if (!$run_user || mysqli_num_rows($run_user) === 0) {
            echo "<script>alert('User not found')</script>";
            echo "<script>window.open('home.php', '_self')</script>";
            return;
        }

        $row_user = mysqli_fetch_assoc($run_user);
        $user_name = $row_user['user_name'];
        $user_image = $row_user['user_image'];

        if (!isset($_SESSION['user_email'])) {
            echo "<script>alert('You need to login first')</script>";
            echo "<script>window.open('home.php', '_self')</script>";
            return;
        }

        $user_com = $_SESSION['user_email'];
        $get_com = "SELECT * FROM users WHERE user_email = '$user_com'";
        $run_com = mysqli_query($con, $get_com);

        if (!$run_com || mysqli_num_rows($run_com) === 0) {
            echo "<script>alert('User not found')</script>";
            echo "<script>window.open('home.php', '_self')</script>";
            return;
        }

        $row_com = mysqli_fetch_assoc($run_com);
        $user_com_id = $row_com['user_id'];
        $user_com_name = $row_com['user_name'];

        $post_id = $_GET['post_id'];
        $get_user = "SELECT * FROM posts WHERE post_id = '$post_id'";
        $run_user = mysqli_query($con, $get_user);

        if (!$run_user || mysqli_num_rows($run_user) === 0) {
            echo "<script>alert('Post not found')</script>";
            echo "<script>window.open('home.php', '_self')</script>";
            return;
        }

        $row = mysqli_fetch_assoc($run_user);
        $p_id = $row['post_id'];

        if ($p_id != $post_id) {
            echo "<script>alert('ERROR')</script>";
            echo "<script>window.open('home.php' , '_self')</script>";
            return;
        }

echo "
<div class='comment-page-container'>
    <!-- Post Card -->
    <div class='post-card'>
        <div class='post-content'>
            <!-- Post Header -->
            <div class='post-header'>
                <img src='users/$user_image' alt='$user_name' class='post-user-avatar'>
                <div class='post-meta'>
                    <h5 class='post-username'>$user_name</h5>
                    <small class='post-timestamp'>Posted on $post_date</small>
                </div>
            </div>
            
            <!-- Post Content -->
            <div class='post-text-content'>
                <p>$content</p>";

if (!empty($upload_image)) {
    $image_path = "PostImage/$upload_image";
    if (file_exists($image_path)) {
        echo "<div class='post-image-container'>
                <img src='$image_path' class='post-media-image'>
              </div>";
    } else {
        echo "<div class='post-image-missing'>Image not found.</div>";
    }
}

echo "      </div>
        </div>
    </div>
    
    <!-- Comments Section -->
    <div class='comments-container'>
        <div class='comments-header'>
            <h5 class='comments-title'><i class='comments-icon'></i>Comments</h5>
            <small class='comments-count' id='comment-count'></small>
        </div>
        <div id='comments-container' class='comments-list'></div>  <!-- Changed id to comments-container -->
    </div>
    
    <!-- Comment Form -->
    <div class='comment-form-container'>
        <form id='commentForm' class='comment-form'>
            <h5 class='comment-form-title'>Leave a comment</h5>
            <div class='comment-input-container'>
                <textarea name='comment' id='commentText' placeholder='Write your thoughts here...' class='comment-textarea'></textarea>
                <label for='commentText' class='comment-label'>Your comment...</label>
            </div>
            <input type='hidden' id='postId' value='$post_id'>
            <div class='comment-submit-container'>
                <button type='submit' class='comment-submit-button'>
                    <i class='comment-submit-icon'></i> Post Comment
                </button>
            </div>
        </form>
    </div>
</div>";
        
    }
}

// My posts 

function user_posts()
{
    global $con;

    if (isset($_GET['u_id'])) {
        $u_id = $_GET['u_id'];
    } else {
        return; // Exit if no user ID is provided
    }

    // Get user information first
    $user_query = "SELECT * FROM users WHERE user_id = '$u_id'";
    $run_user = mysqli_query($con, $user_query);

    if (!$run_user || mysqli_num_rows($run_user) === 0) {
        echo "<script>alert('User not found')</script>";
        echo "<script>window.open('home.php', '_self')</script>";
        return;
    }

    $row_user = mysqli_fetch_array($run_user);
    $f_name = $row_user['f_name'];
    $l_name = $row_user['l_name'];
    $user_image = $row_user['user_image'];

    // Get posts
    $get_posts = "SELECT * FROM posts WHERE user_id = '$u_id' ORDER BY post_id DESC LIMIT 5";
    $run_posts = mysqli_query($con, $get_posts);

    $post_count = mysqli_num_rows($run_posts);

  
    echo "<div class='user-posts-container'>";

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
                <div class='post-header'>
                    <a href='user_profile.php?u_id=$u_id'>
                        <img src='users/$user_image' class='post-user-img' onerror=\"this.src='users/default.png'\">
                    </a>
                    <div class='post-user-info'>
                        <h4 class='post-user-name'>
                            <a href='user_profile.php?u_id=$u_id'>$f_name $l_name</a>
                        </h4>
                        <span class='post-date'>$formatted_date</span>
                    </div>
                </div>";

            if ($content != "No content") {
                echo "<div class='post-content'>$content</div>";
            }

            if (!empty($upload_image)) {
                $image_path = "PostImage/$upload_image";
                if (file_exists($image_path)) {
                    echo "<div class='post-image-container'>
                            <img src='$image_path' class='post-image' alt='Post Image'>
                          </div>";
                } else {
                    echo "<div class='alert alert-warning'>Image not found</div>";
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

    echo "</div>"; // Close user-posts-container
}


// posts search 

function results() {
    global $con;

    // Get search query if exists
    $is_search = isset($_GET['search']);
    $search_query = $is_search ? htmlentities($_GET['user_query']) : '';

    // Build the query
    if ($is_search) {
        $get_posts = "SELECT * FROM posts 
                      WHERE post_content LIKE '%$search_query%' 
                      OR upload_image LIKE '%$search_query%'
                      ORDER BY post_date DESC";
    } else {
        $get_posts = "SELECT * FROM posts ORDER BY post_date DESC LIMIT 50";
    }

    $run_posts = mysqli_query($con, $get_posts);
    $num_results = mysqli_num_rows($run_posts);

    echo "<div class='posts-search-container' style='max-width: 800px; margin: 0 auto;'>";

    if ($num_results > 0) {
        while ($row_posts = mysqli_fetch_array($run_posts)) {
            $post_id = $row_posts['post_id'];
            $user_id = $row_posts['user_id'];
            $content = $row_posts['post_content'];
            $upload_image = $row_posts['upload_image'];
            $post_date = $row_posts['post_date'];

            // Get user info
            $user = "SELECT * FROM users WHERE user_id = '$user_id' AND posts = 'yes'";
            $run_user = mysqli_query($con, $user);
            $row_user = mysqli_fetch_array($run_user);

            $user_name = $row_user['user_name'];
            $first_name = $row_user['f_name'];
            $last_name = $row_user['l_name'];
            $user_image = $row_user['user_image'];
            $default_image = 'default.jpg';

            // Format post date
            $formatted_date = date("F j, Y \a\\t g:i a", strtotime($post_date));

            // Display post
            echo "
            <div class='post-card' style='margin: 20px 0; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>
                <div class='post-header' style='display: flex; align-items: center; margin-bottom: 15px;'>
                    <a href='user_profile.php?u_id=$user_id' class='author-avatar' style='margin-right: 15px;'>
                        <img src='users/" . (file_exists("users/$user_image") ? $user_image : $default_image) . "' 
                             alt='$user_name' style='width: 50px; height: 50px; border-radius: 50%; object-fit: cover;'>
                    </a>
                    <div class='author-info'>
                        <h4 style='margin: 0; font-size: 16px;'>
                            <a href='user_profile.php?u_id=$user_id' style='text-decoration: none; color: #333;'>$first_name $last_name</a>
                        </h4>
                        <p style='margin: 0; color: #777; font-size: 13px;'>$formatted_date</p>
                    </div>
                </div>
                
                <div class='post-content' style='margin-bottom: 15px;'>
                    <p style='margin: 0; line-height: 1.5;'>" . nl2br(htmlspecialchars($content)) . "</p>
            ";


 // Show image if exists 
            if (!empty($upload_image)) {
                $image_path = "PostImage/$upload_image";
                if (file_exists($image_path)) {
                    echo "
                    <div class='post-image' style='margin-top: 15px; text-align: center;'>
                        <img src='$image_path' alt='Post image' style='max-width: 100%; max-height: 500px; border-radius: 8px;'>
                    </div>
                    ";
                }
            }

            echo "
                </div>
                
                <div class='post-actions' style='border-top: 1px solid #eee; padding-top: 15px;'>
                    <a href='single_post.php?post_id=$post_id' class='view-post-btn' style='display: inline-flex; align-items: center; color: #4361ee; text-decoration: none;'>
                        <svg width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='#4361ee' stroke-width='2' style='margin-right: 5px;'>
                            <path d='M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z'></path>
                            <circle cx='12' cy='12' r='3'></circle>
                        </svg>
                        View Post
                    </a>
                </div>
            </div>
            ";
        }
    } else {
        $message = $is_search
            ? "No posts found for '$search_query'"
            : "No posts found in the community yet";

        echo "
        <div class='no-results' style='text-align: center; padding: 40px; color: #777;'>
            <div class='no-results-icon' style='font-size: 40px; margin-bottom: 15px;'>
                <i class='far fa-file-alt'></i>
            </div>
            <h3 class='no-results-text' style='margin: 0;'>$message</h3>
        </div>
        ";
    }

    echo "</div>";
}

// user search 
function search_user()
{
    global $con;

    $is_search = isset($_GET['search_user_btn']);
    $search_query = $is_search ? htmlentities($_GET['search_user']) : '';

    if ($is_search) {
        $get_user = "SELECT * FROM users 
                    WHERE f_name LIKE '%$search_query%' 
                    OR l_name LIKE '%$search_query%' 
                    OR user_name LIKE '%$search_query%'";
    } else {
        $get_user = "SELECT * FROM users ORDER BY user_reg_date DESC LIMIT 50";
    }

    $run_user = mysqli_query($con, $get_user);
    $num_results = mysqli_num_rows($run_user);

    echo "<div class='user-search-container'>";

    if ($num_results > 0) {
        while ($row_user = mysqli_fetch_array($run_user)) {
            $user_id = $row_user['user_id'];
            $f_name = $row_user['f_name'];
            $l_name = $row_user['l_name'];
            $username = $row_user['user_name'];
            $user_image = $row_user['user_image'];
            $default_image = 'default.jpg';

            echo "
            <div class='user-card'>
                <div class='user-avatar'>
                    <a href='user_profile.php?u_id=$user_id'>
                        <img src='users/" . (file_exists("users/$user_image") ? $user_image : $default_image) . "' 
                             alt='$username' class='profile-image'>
                    </a>
                </div>
                <div class='user-info'>
                    <h3 class='user-name'>
                        <a href='user_profile.php?u_id=$user_id'>$f_name $l_name</a>
                    </h3>
                    <p class='user-username'>@$username</p>
                    <div class='user-actions'>
                        <a href='user_profile.php?u_id=$user_id' class='profile-btn'>
                            <svg width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2'>
                                <path d='M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2'></path>
                                <circle cx='12' cy='7' r='4'></circle>
                            </svg>
                            View Profile
                        </a>
                    </div>
                </div>
            </div>
            ";
        }
    } else {
        $message = $is_search
            ? "No users found for '$search_query'"
            : "No users found in the community yet";

        echo "
        <div class='no-results'>
            <div class='no-results-icon'>
                <i class='far fa-user'></i>
            </div>
            <h3 class='no-results-text'>$message</h3>
        </div>
        ";
    }

    echo "</div>";
}
?>





<style>
    .user-search-container {
        display: flex;
        flex-direction: column;
        max-width: 1000px;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .user-card {
        display: flex;
        align-items: center;
        background: #fff;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .user-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .user-avatar {
        margin-right: 16px;
    }

    .profile-image {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f0f2f5;
    }

    .user-info {
        flex: 1;
    }

    .user-name {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .user-name a {
        color: #2d3436;
        text-decoration: none;
    }

    .user-name a:hover {
        color: #0984e3;
    }

    .user-username {
        margin: 4px 0 8px;
        color: #636e72;
        font-size: 0.9rem;
    }

    .user-actions {
        margin-top: 8px;
    }

    .profile-btn {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        background-color: #0984e3;
        color: white;
        border-radius: 20px;
        text-decoration: none;
        font-size: 0.85rem;
        transition: background-color 0.2s ease;
    }

    .profile-btn:hover {
        background-color: #0767b3;
    }

    .profile-btn svg {
        margin-right: 6px;
    }



    /* no post styling for my posts  */
    /* User Posts Container */
    .user-posts-container {
        max-width: 950px;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* Post Card with fixed width */
    .post-card {
        background-color: white;
        border-radius: var(--border-radius);
        /* box-shadow: var(--box-shadow); */
        margin-bottom: 25px;
        transition: var(--transition);
        border: 1px solid rgba(0, 0, 0, 0.05);
        width: 100%;
        max-width: 950px;
    }

    /* No Posts Style */
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

    .post-image-container {
        padding: 0 15px 15px 15px;
    }

    .post-image {
        max-width: 100%;
        border-radius: 8px;
        margin-bottom: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

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
        color: var(--primary-color);
    }

    .post-action:hover i {
        transform: scale(1.1);
    }
</style>