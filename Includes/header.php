<?php
include("Includes/connection.php");
include("Functions/function.php");

$user = $_SESSION['user_email'];
$get_user = "SELECT * FROM users WHERE user_email='$user'";
$run_user = mysqli_query($con, $get_user);
$row = mysqli_fetch_array($run_user);

$user_id = $row['user_id'];
$user_name = $row['user_name'];
$first_name = $row['f_name'];
$last_name = $row['l_name'];
$describe_user = $row['describe_user'];
$user_image = $row['user_image'];

$user_posts = "SELECT * FROM posts WHERE user_id='$user_id'";
$run_posts = mysqli_query($con, $user_posts);
$posts = mysqli_num_rows($run_posts);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SnapCircle</title>

 <!-- Bootstrap CSS & JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    
  


<style !important>
 
    :root{
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
        padding-top: 70px;
        transition: padding-left 0.3s ease;
        font-family: 'Poppins', sans-serif;
    }

    /* Navbar Container */
    nav.navbar.navbar-default.navbar-fixed {
        position: fixed !important;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1030;
        background-color: white;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: var(--box-shadow);
        min-height: 70px;
    }

    .navbar-flex {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        padding: 5px 15px;
        position: relative;
    }

    /* Logo Section */
    .navbar-brand-section {
        display: flex;
        align-items: center;
        flex: 1;
        justify-content: center;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        font-size: 22px;
        font-weight: 600;
        gap: 8px;
        color: var(--dark-color);
        text-decoration: none;
        transition: var(--transition);
    }

    .navbar-brand:hover {
        color: var(--primary-color);
    }

    .navbar-brand .glyphicon {
        color: var(--primary-color);
        font-size: 20px;
    }

    /* Mobile Menu Button */
    .mobile-menu-btn {
        display: none;
        background: none;
        border: none;
        font-size: 24px;
        color: var(--dark-color);
        cursor: pointer;
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        transition: var(--transition);
    }

    .mobile-menu-btn:hover {
        color: var(--primary-color);
    }

    /* Navigation Links */
    .navbar-left-section,
    .navbar-right-section {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .navbar-left-section a,
    .navbar-right-section a {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 15px;
        color: var(--gray-color);
        text-decoration: none;
        font-weight: 500;
        border-radius: var(--border-radius);
        transition: var(--transition);
        white-space: nowrap;
        font-size: 15px;
    }

    .navbar-left-section a:hover,
    .navbar-right-section a:hover {
        background-color: rgba(67, 97, 238, 0.1);
        color: var(--primary-color);
    }

    .navbar-left-section a .glyphicon,
    .navbar-right-section a .glyphicon {
        font-size: 16px;
    }

    /* Search Section */
    .navbar-center-section {
        flex: 1 1 100%;
        order: 3;
        margin: 10px 0;
        display: flex;
        justify-content: center;
    }

    .input-group {
        width: 100%;
        max-width: 500px;
        
    }

    .input-group .form-control {
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: var(--border-radius);
        padding: 10px 19px;
        font-family: 'Poppins', sans-serif;
        transition: var(--transition);
        
    }

    .input-group .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.16);
    }

    .input-group-addon button {
        border: none;
        background: none;
        padding: 0;
        cursor: pointer;
      
        
    }

    .input-group-addon .glyphicon-search {
        color: var(--primary-color);
        font-size: 16px;
        
    }

    /* Create Post Button */
    #openPostModal {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-radius: var(--border-radius);
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        padding: 10px 20px;
        font-weight: 500;
        border: none;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }

    #openPostModal:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(67, 97, 238, 0.4);
    }

    /* Profile Dropdown */
    .dropdown.navbar-profile {
        position: relative;
    }

    .dropdown-toggle {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .dropdown-toggle img {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(67, 97, 238, 0.2);
    }

    .dropdown-toggle .caret {
        transition: var(--transition); 
       
    }

    .dropdown.open .caret {
        transform: rotate(180deg);
        margin-right: 30px;
        
    }

    .dropdown-menu {
        position: absolute;
        right: 0;
        left: auto;
        min-width: 220px;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        border: none;
        padding: 10px 0;
        margin-top: 10px;border-radius: 30px;
         box-shadow: var(--box-shadow);
        
    }

    .dropdown-menu li a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        color: var(--gray-color);
        transition: var(--transition);
        font-size: 14px;
    }

    .dropdown-menu li a:hover {
        background-color: rgba(67, 97, 238, 0.1);
        color: var(--primary-color);
    }

    .dropdown-menu li a .glyphicon {
        width: 18px;
        text-align: center;
    }

    .dropdown-menu .divider {
        margin: 5px 0;
        background-color: rgba(0, 0, 0, 0.05);
    }

    /* Badge styling */
    .badge {
        background-color: #4361ee;
        color: #fff;
        font-weight: 500;
        margin-left: auto;
    }

    /* Logout button styling */
    .dropdown-menu .btn-link {
          border-radius: var(--border-radius);
            /* padding: 12px 35px; */
            font-weight: 500;
            transition: var(--transition);
            font-size: 15px;
            margin-left: 17px;
            letter-spacing: 0.5px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
    }

    .dropdown-menu .btn-link:hover {
        /* background-color: rgba(67, 97, 238, 0.1); */
        color: var(--primary-color);
    }

    /* Sidebar Styles */
    .sidebar {
        position: fixed;
        top: 0;
        left: -300px;
        width: 280px;
        height: 100%;
        background-color: #fff;
        z-index: 1040;
        transition: all 0.3s ease;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
        padding-top: 20px;
    }

    .sidebar.open {
        left: 0;
    }

    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1039;
        display: none;
    }

    .sidebar-profile {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        margin-bottom: 10px;
    }


    .sidebar-profile img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 10px;
        border: 3px solid rgba(67, 97, 238, 0.2);
    }

    .sidebar-profile h4 {
        margin: 5px 0;
        font-size: 16px;
        font-weight: 500;
        color: var(--dark-color);
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-menu li a {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: var(--gray-color);
        text-decoration: none;
        transition: var(--transition);
        border-left: 3px solid transparent;
        font-size: 15px;
    }

    .sidebar-menu li a:hover {
        background-color: rgba(67, 97, 238, 0.05);
        border-left: 3px solid var(--primary-color);
        color: var(--primary-color);
    }

    .sidebar-menu li a .glyphicon {
        margin-right: 10px;
        width: 20px;
        text-align: center;
        font-size: 16px;
    }

    .sidebar-search {
        padding: 15px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .sidebar-create-post {
        padding: 15px;
    }

    .sidebar-create-post button {
        width: 100%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border: none;
        padding: 12px;
        border-radius: var(--border-radius);
        font-weight: 500;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }

    .sidebar-create-post button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(67, 97, 238, 0.4);
    }

      .sidebar .btn-link {
          border-radius: var(--border-radius);
            padding: 12px 28px;
            font-weight: 500;
            transition: var(--transition);
            font-size: 15px;
            letter-spacing: 0.5px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
    }

      .sidebar .btn-link:hover {
        background-color: rgba(56, 86, 218, 0.1);
        color: var(--primary-color);
    }


    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow-y: auto;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s ease-out;
    }

    .modal-content {
        background-color: #ffffff;
        margin: 5% auto;
        padding: 30px;
        width: 90%;
        max-width: 600px;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        animation: slideIn 0.4s ease-in-out;
        position: relative;
        font-family: 'Poppins', sans-serif;
    }

    .close {
        position: absolute;
        top: 15px;
        right: 20px;
        color: var(--gray-color);
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        transition: var(--transition);
    }

    .close:hover,
    .close:focus {
        color: var(--dark-color);
    }

    .modal-content h2 {
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 22px;
        font-weight: 600;
        color: var(--dark-color);
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .modal-content .form-group {
        margin-bottom: 20px;
    }

    .modal-content textarea.form-control {
        width: 100%;
        padding: 15px;
        font-size: 15px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: var(--border-radius);
        resize: vertical;
        font-family: inherit;
        transition: var(--transition);
        min-height: 120px;
    }

    .modal-content textarea.form-control:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    #image-preview-container {
        text-align: center;
        margin: 15px 0;
    }

    #image-preview {
        max-width: 100%;
        max-height: 200px;
        border-radius: var(--border-radius);
        object-fit: contain;
        box-shadow: var(--box-shadow);
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
    }

    .modal-content .btn {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 500;
        border: none;
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: var(--transition);
    }

    .modal-content .btn .glyphicon {
        margin-right: 8px;
    }

    .modal-content .btn-warning {
        background-color: #f0ad4e;
        color: #fff;
    }

    .modal-content .btn-warning:hover {
        background-color: #ec971f;
        transform: translateY(-1px);
    }

    .modal-content .btn-success {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: #fff;
    }

    .modal-content .btn-success:hover {
        background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        transform: translateY(-1px);
    }

    #upload_image_button input[type="file"] {
        display: none;
    }

    /* Responsive adjustments */
    @media (min-width: 992px) {
        body {
            padding-top: 70px;
        }

        .navbar-flex {
            flex-wrap: nowrap;
        }

        .navbar-brand-section {
            flex: 0 0 auto;
            justify-content: flex-start;
        }

        .navbar-center-section {
            flex: 1;
            order: 0;
            margin: 0;
            padding: 0 20px;
        }

        .navbar-left-section,
        .navbar-right-section {
            flex: 0 0 auto;
        }
    }

    @media (max-width: 991px) {
        .mobile-menu-btn {
            display: block;
        }

        .navbar-left-section,
        .navbar-center-section,
        .navbar-right-section {
            display: none !important;
        }

        .navbar-brand-section {
            justify-content: center;
        }

        body.sidebar-open {
            overflow: hidden;
        }

        body.sidebar-open .sidebar-overlay {
            display: block;
        }
    }

    @media (max-width: 576px) {
        .modal-content {
            padding: 20px;
            width: 95%;
        }

        .modal-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .modal-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideIn {
        from {
            transform: translateY(-40px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>

</head>
<body>

<!-- Sidebar Structure -->
<div class="sidebar-overlay"></div>
<aside class="sidebar">
    <div class="sidebar-profile">
        <img src="users/<?php echo $user_image; ?>" alt="Profile Image">
        <h4><?php echo $first_name . ' ' . $last_name; ?></h4>
    </div>

    <div class="sidebar-search">
        <form class="navbar-form" method="get" action="results.php">
            <div class="input-group">
                <span class="input-group-addon">
                    <button type="submit" name="search">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
                <input type="text" class="form-control" name="user_query" placeholder="Search">
            </div>
        </form>
    </div>

    <div class="sidebar-create-post">
        <button id="openPostModalSidebar" class="btn btn-primary" style="width: 100%;">
            <span class="glyphicon glyphicon-pencil"></span> Create Post
        </button>
    </div>

    <ul class="sidebar-menu">
        <li><a href="home.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
        <li><a href="members.php"><span class="glyphicon glyphicon-search"></span> Find People</a></li>
        <li><a href="messages.php?u_id=new"><span class="glyphicon glyphicon-envelope"></span> Messages</a></li>
        <li><a href='my_post.php?u_id=<?php echo $user_id; ?>'><span class="glyphicon glyphicon-file"></span> My Posts</a></li>
        <li><a href="profile.php?u_id=<?php echo $user_id; ?>"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
        <li><a href="edit_profile.php?u_id=<?php echo $user_id; ?>"><span class="glyphicon glyphicon-edit"></span> Edit Profile</a></li>
        <li>
            <form method="post" action="logout.php">
                <button type="submit" class="btn btn-link" style="text-align: left; width: 100%;">
                    <span class="glyphicon glyphicon-log-out"></span> Logout
                </button>
            </form>
        </li>
    </ul>
</aside>

<!-- Navbar Structure -->
<nav class="navbar navbar-default navbar-fixed">
    <div class="container-fluid">
        <div class="navbar-flex">
            <!-- Mobile Menu Button (far left) -->
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <span class="glyphicon glyphicon-menu-hamburger"></span>
            </button>

            <!-- Centered Logo -->
            <div class="navbar-brand-section">
                <a class="navbar-brand" href="home.php">
                    <span></span>
                    <span style="color: var(--primary-color);"> <i class="fa-solid fa-circle-notch"></i> Snap</span><span>Circle</span>
                </a>
            </div>

            <!-- Desktop Navigation (hidden on mobile) -->
            <div class="navbar-left-section">
                <a href="home.php"><span class="glyphicon glyphicon-home"></span> Home</a>
                <a href="members.php"><span class="glyphicon glyphicon-search"></span> Find People</a>
                <a href="messages.php?u_id=new"><span class="glyphicon glyphicon-envelope"></span> Messages</a>
            </div>

            <!-- Search Section (hidden on mobile) -->
            <div class="navbar-center-section">
                <form class="navbar-form" method="get" action="results.php">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <button type="submit" name="search">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                        <input type="text" class="form-control" name="user_query" placeholder="Search">
                    </div>
                </form>
            </div>

            <!-- Right Section (Create Post + Profile) (hidden on mobile) -->
            <div class="navbar-right-section">
                <button id="openPostModal" class="btn btn-primary">
                    <span class="glyphicon glyphicon-pencil"></span><span> Create Post</span>
                </button>
                <div class="dropdown navbar-profile">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="users/<?php echo $user_image; ?>" class="img-circle" width="36" height="36">
                        <span class="hidden-xs"><?php echo $first_name; ?></span> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href='my_post.php?u_id=<?php echo $user_id; ?>'>
                                <span class="glyphicon glyphicon-file"></span> My Posts
                                <span class='badge'><?php echo $posts; ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="profile.php?u_id=<?php echo $user_id; ?>">
                                <span class="glyphicon glyphicon-user"></span> View Profile
                            </a>
                        </li>
                        <li>
                            <a href="edit_profile.php?u_id=<?php echo $user_id; ?>">
                                <span class="glyphicon glyphicon-edit"></span> Edit Profile
                            </a>
                        </li>
                        <li>
                            <form method="post" action="logout.php">
                                <button type="submit" class="btn btn-link">
                                    <span class="glyphicon glyphicon-log-out"></span> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Modal for Post Creation -->
<div id="postModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Create a Post</h2>
        <form action="home.php?id=<?php echo urlencode($user_id); ?>" method="post" id="f" enctype="multipart/form-data">
            <div class="form-group">
                <textarea class="form-control" id="content" rows="5" name="content" placeholder="What's on your mind?"></textarea>
            </div>

            <!-- Image Preview Section -->
            <div class="form-group" id="image-preview-container" style="display: none;">
                <img id="image-preview" src="" alt="Image Preview">
                <button type="button" id="remove-image-btn" class="btn btn-danger btn-sm" style="margin-top: 10px;">
                    <span class="glyphicon glyphicon-remove"></span> Remove Image
                </button>
            </div>

            <div class="modal-actions">
                <label class="btn btn-warning" id="upload_image_button">
                    <span class="glyphicon glyphicon-camera"></span> Select Image
                    <input type="file" name="upload_image" size="30" accept="image/*">
                </label>
                <button id="btn-post" class="btn btn-success" name="sub">
                    <span class="glyphicon glyphicon-send"></span> Post
                </button>
            </div>
        </form>
        <?php
        // Ensure the function exists before calling
        if (function_exists('insertPost')) {
            insertPost();
        } else {
            echo "<p>Error: insertPost() function not found.</p>";
        }
        ?>
    </div>
</div>

<!-- JavaScript -->
<script>
    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.querySelector('.sidebar');
    const sidebarOverlay = document.querySelector('.sidebar-overlay');
    const body = document.body;

    mobileMenuBtn.addEventListener('click', function() {
        sidebar.classList.toggle('open');
        sidebarOverlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none';
        body.classList.toggle('sidebar-open');
    });

    sidebarOverlay.addEventListener('click', function() {
        sidebar.classList.remove('open');
        sidebarOverlay.style.display = 'none';
        body.classList.remove('sidebar-open');
    });

    // Modal handling
    var modal = document.getElementById("postModal");
    var btn = document.getElementById("openPostModal");
    var btnSidebar = document.getElementById("openPostModalSidebar");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
        body.classList.add('modal-open');
    }

    btnSidebar.onclick = function() {
        modal.style.display = "block";
        body.classList.add('modal-open');
        sidebar.classList.remove('open');
        sidebarOverlay.style.display = 'none';
        body.classList.remove('sidebar-open');
    }

    span.onclick = function() {
        modal.style.display = "none";
        body.classList.remove('modal-open');
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            body.classList.remove('modal-open');
        }
    }

    // Image preview functionality
    const imageInput = document.querySelector('input[name="upload_image"]');
    const imagePreview = document.getElementById("image-preview");
    const imagePreviewContainer = document.getElementById("image-preview-container");
    const removeImageBtn = document.getElementById("remove-image-btn");

    imageInput.addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreviewContainer.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    });

    removeImageBtn.addEventListener('click', function() {
        imagePreview.src = '';
        imagePreviewContainer.style.display = 'none';
        imageInput.value = '';
    });

    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown-menu').hide();
        }
    });
</script>

</body>
</html>