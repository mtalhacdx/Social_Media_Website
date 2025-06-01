<!DOCTYPE html>
<?php
session_start();
include("includes/header.php");

if (!isset($_SESSION['user_email'])) {
    header("location: index.php");
    exit();
}
?>
<html>

<head>
    <title>Find People</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

    <!-- Bootstrap CSS & JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;

        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .members-container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem clamp(1rem, 5vw, 3rem);
            box-sizing: border-box;
        }

        .section-title {
            text-align: center;
            font-size: clamp(1.5rem, 4vw, 2.2rem);
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .section-title:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: min(80px, 50%);
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }

        .search-container {
            width: 100%;
            max-width: 700px;
            margin: 0 auto 3rem;
        }

        .search-form {
            display: flex;
            box-shadow: var(--box-shadow);
            border-radius: var(--border-radius);
            overflow: hidden;
            width: 100%;
        }

        .search-input {
            flex: 1;
            padding: clamp(0.75rem, 2vw, 1rem) clamp(1rem, 3vw, 1.5rem);
            border: none;
            font-size: clamp(0.9rem, 2vw, 1.1rem);
            outline: none;
            font-family: 'Poppins', sans-serif;
            min-width: 0;
        }

        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.16);
        }

        .search-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 0 clamp(1rem, 3vw, 1.5rem);
            cursor: pointer;
            transition: var(--transition);
            font-size: clamp(0.9rem, 2vw, 1.1rem);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-btn:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        }

        .user-search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
        }

        .user-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 1.5rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            width: 800px;
            box-sizing: border-box;
        }

        .user-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .user-avatar {
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .profile-image {
            width: clamp(50px, 10vw, 70px);
            height: clamp(50px, 10vw, 70px);
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(67, 97, 238, 0.1);
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-size: clamp(1rem, 2vw, 1.2rem);
            font-weight: 600;
            margin-bottom: 0.3rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-name a {
            color: var(--dark-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .user-name a:hover {
            color: var(--primary-color);
        }

        .user-username {
            color: var(--gray-color);
            font-size: clamp(0.8rem, 1.5vw, 0.9rem);
            margin-bottom: 0.8rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 1rem;
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            border-radius: var(--border-radius);
            font-size: clamp(0.8rem, 1.5vw, 0.9rem);
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
            white-space: nowrap;
        }

        .profile-btn:hover {
            background-color: rgba(67, 97, 238, 0.2);
            color: var(--primary-color);
        }

        .profile-btn svg {
            margin-right: 0.5rem;
            width: 14px;
            height: 14px;
        }

        .no-results {
            text-align: center;
            padding: 3rem;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            grid-column: 1 / -1;
            max-width: 800px;
            margin: 0 auto;
            width: 100%;
        }

        .no-results-icon {
            font-size: clamp(3rem, 10vw, 5rem);
            color: #dee2e6;
            margin-bottom: 1.5rem;
        }

        .no-results-text {
            font-size: clamp(1rem, 3vw, 1.2rem);
            color: var(--gray-color);
            margin: 0;
        }

        /* Large screens (1200px and up) */
        @media (min-width: 1200px) {
            .user-search-container {
                grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
                max-width: 850px;
            }

            .user-card {
                padding: 1.75rem;
            }
        }

        /* Extra large screens (1400px and up) */
        @media (min-width: 1400px) {
            .user-search-container {
                grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
                max-width: 900px;
            }
        }

        /* Medium screens (992px to 1199px) */
        @media (max-width: 1199px) {
            .user-search-container {
                max-width: 750px;
            }
        }

        /* Small screens (768px to 991px) */
        @media (max-width: 991px) {
            .user-search-container {
                max-width: 700px;
                grid-template-columns: repeat(auto-fill, minmax(min(100%, 320px), 1fr));
            }
        }

        /* Extra small screens (576px to 767px) */
        @media (max-width: 830px) {
            .members-container {
                max-width: 600px;
                padding: 1.5rem;
            }

            .user-card {
                max-width: 650px;

            }

            .section-title {
                margin-bottom: 1.5rem;
            }

            .search-container {
                margin-bottom: 2rem;
            }
        }
        @media (max-width: 700px) {
            .members-container {
                max-width: 470px;
                padding: 1.5rem;
            }

            .user-card {
                max-width: 500px;

            }

            .section-title {
                margin-bottom: 1.5rem;
            }

            .search-container {
                margin-bottom: 2rem;
            }
        }

        /* Mobile screens (up to 575px) */
        @media (max-width: 575px) {
            .members-container {
                padding: 1.5rem 1rem;
            }

            .user-card {
                flex-direction: column;
                text-align: center;
                padding: 1.5rem 1rem;
                max-width: 350px;
            }

            .user-avatar {
                margin-right: 0;
                margin-bottom: 1rem;
            }

            .user-info {
                width: 100%;
                text-align: center;
            }

            .user-actions {
                justify-content: center;
                display: flex;
            }

            .no-results {
                padding: 2rem 1rem;
            }
        }

        /* Ultra small screens (up to 400px) */
        @media (max-width: 400px) {
            .search-form {
                flex-direction: column;
                border-radius: var(--border-radius);
                overflow: visible;
                gap: 0.5rem;
            }

            .search-input {
                border-radius: var(--border-radius);
                box-shadow: var(--box-shadow);
                padding: 0.8rem 1rem;
            }

            .search-btn {
                border-radius: var(--border-radius);
                padding: 0.8rem;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="main-content">
        <div class="members-container">
            <h1 class="section-title">
                <i class="fas fa-users"></i> Connect with People
            </h1>

            <div class="search-container">
                <form action="" class="search-form" method="get">
                    <input type="text"
                        name="search_user"
                        class="search-input"
                        placeholder="Search by name or username...">
                    <button class="search-btn" type="submit" name="search_user_btn">
                        <i class="fas fa-search"></i> Search
                    </button>
                </form>
            </div>

            <div class="user-search-container">
                <?php search_user(); ?>
            </div>
        </div>
    </div>
</body>

</html>