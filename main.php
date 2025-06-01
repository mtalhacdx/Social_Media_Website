<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="SnapCircle - Connect with friends and share your moments">
    <title>SnapCircle | Modern Social Network</title>

    <!-- Favicon -->
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

 
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            background-color: var(--light-color);
            color: var(--dark-color);
            line-height: 1.6;
        }

        /* Left Side Styling */
        .left-side {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            overflow: hidden;
        }

        .image-half {
            height: 100%;
            width: 100%;
            object-fit: cover;
            opacity: 0.8;
            transition: opacity var(--transition) ease;
        }

        .left-side:hover .image-half {
            opacity: 0.9;
        }

        .overlay-text {
            position: absolute;
            color: white;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
            padding: 2rem;
            max-width: 80%;
            z-index: 1;
        }

        .overlay-text h3 {
            margin-bottom: 1.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            opacity: 0.9;
            transition: all 0.3s ease;
        
        }

        .overlay-text h3:hover {
            opacity: 1;
            transform: translateX(5px);
        }

        .overlay-text i {
            margin-right: 1rem;
            font-size: 1.2rem;
            color: var(--accent-color);
        }

        /* Right Side Styling */
        .right-side {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: var(--light-color);
            padding: 2rem;
        }

        .right-side-content {
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .logo {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: inline-block;
            font-weight: 600;
        }

        .logo i {
            color: var(--accent-color);
        }

        .right-side-content h1 {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--dark-color);
            line-height: 1.2;
        }

        .right-side-content p {
            color: var(--gray-color);
            margin-bottom: 2rem;
            font-weight: 400;
        }

        /* Button Styling */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 0.8rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 500;
            border-radius: 15px;
            transition: var(--transition);
            box-shadow: var(--box-shadow);
            position: relative;
            overflow: hidden;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
        }

        .btn-primary-custom:active {
            transform: translateY(0);
        }

        /* Popup Styling */
        .popup-box {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1050;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            backdrop-filter: blur(5px);
        }

        .popup-box.active {
            opacity: 1;
            visibility: visible;
        }

        .popup-content {
            background: var(--light-color);
            padding: 2.5rem;
            border-radius: var(--border-radius);
            width: 90%;
            max-width: 450px;
            box-shadow: var(--box-shadow);
            text-align: center;
            position: relative;
            transform: scale(0.9);
            transition: var(--transition);
        }

        .popup-box.active .popup-content {
            transform: scale(1);
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 1.8rem;
            cursor: pointer;
            color: var(--gray-color);
            transition: var(--transition);
        }

        .close-btn:hover {
            color: var(--primary-color);
        }

        .popup-content h4 {
            color: var(--dark-color);
            margin-bottom: 2rem;
            font-weight: 600;
        }

        .popup-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .btn-login,
        .btn-signup {
            width: 100%;
            padding: 0.8rem;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 15px;
            transition: var(--transition);
            border: none;
            cursor: pointer;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .btn-signup {
            background-color: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .btn-signup:hover {
            background-color: var(--light-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
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

        @keyframes slideInRight {
            from {
                transform: translateX(50px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0);
            }
        }

        .slide-in {
            animation: slideInRight 0.8s ease-out forwards;
        }

        .fade-in {
            animation: fadeIn 1.2s ease-in forwards;
        }

        .float-animation {
            animation: float 4s ease-in-out infinite;
        }

        /* Responsive Design */
        @media (max-width: 991.98px) {
            .left-side {
                height: 40vh;
            }

            .right-side {
                height: 60vh;
            }

            .right-side-content {
                max-width: 100%;
            }

            .overlay-text {
                text-align: center;
                max-width: 90%;
            }

            .overlay-text h3 {
                margin-bottom: 1rem;
                font-size: 1rem;
            }
        }

        @media (max-width: 767.98px) {
            .left-side {
                height: 35vh;
            }

            .right-side {
                height: 65vh;
                padding: 1.5rem;
            }

            .right-side-content h1 {
                font-size: 1.8rem;
                margin-bottom: 1rem;
            }

            .right-side-content p {
                font-size: 0.95rem;
                margin-bottom: 1.5rem;
            }

            .btn-primary-custom {
                padding: 0.7rem 2rem;
                font-size: 1rem;
            }

            .popup-content {
                padding: 1.5rem;
            }
        }

        @media (max-width: 575.98px) {
            .left-side {
                height: 30vh;
            }

            .right-side {
                height: 70vh;
            }

            .overlay-text h3 {
                font-size: 0.9rem;
            }

            .right-side-content h1 {
                font-size: 1.5rem;
            }
        }

    </style>

   
</head>

<body>
    <div class="container-fluid g-0">
        <div class="row min-vh-100 g-0">

            <!-- Left Image Section -->
            <div class="col-lg-6 p-0 left-side">
                <img src="images/loginback.jpg" alt="SnapCircle Social Network" class="image-half position-absolute w-100 h-100" />
                <div class="overlay-text text-center text-lg-start">
                    <h3><i class="fas fa-search"></i> <strong>Follow Your Interests</strong></h3>
                    <h3><i class="fas fa-users"></i> <strong>Connect with like-minded people</strong></h3>
                    <h3><i class="fas fa-bolt"></i> <strong>Share your moments instantly</strong></h3>
                </div>
            </div>

            <!-- Right Content Section -->
            <div class="col-lg-6 right-side">
                <div class="right-side-content">
                    <div class="logo float-animation">
                        <i class="fas fa-circle-notch"></i> SnapCircle
                    </div>
                    <h1 class="fw-bold slide-in">Join Our Social Community</h1>
                    <p class="fade-in">Connect with friends, share your stories, and discover what's happening around you.</p>
                    <button class="btn btn-primary-custom mt-3" onclick="togglePopup()">Get Started <span> <i class="fas fa-arrow-right me-2"></i></span></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Popup -->
    <div id="popupBox" class="popup-box">
        <div class="popup-content">
            <span class="close-btn" onclick="togglePopup()">&times;</span>
            <h4>Welcome to SnapCircle</h4>
            <p class="text-muted mb-4">Join our community or sign in to continue</p>
            <form method="POST" class="popup-form">
                <button class="btn btn-login" id="LoginBtn" name="login">
                    <i class="fas fa-sign-in-alt me-2"></i> Login
                </button>
                <button class="btn btn-signup" id="SignupBtn" name="signup">
                    <i class="fas fa-user-plus me-2"></i> Sign Up
                </button>
            </form>
            <div class="mt-3">
                <p class="text-muted small">By continuing, you agree to our <a href="#" class="text-primary">Terms</a> and <a href="#" class="text-primary">Privacy Policy</a>.</p>
            </div>

            <!-- PHP Redirections -->
            <?php
            if (isset($_POST['signup'])) {
                echo "<script>window.open('signup.php', '_self')</script>";
            }
            if (isset($_POST['login'])) {
                echo "<script>window.open('login.php', '_self')</script>";
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePopup() {
            const popup = document.getElementById('popupBox');
            popup.classList.toggle('active');
        }
    </script>
</body>
</html>