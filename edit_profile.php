<!DOCTYPE html>
<?php
session_start();
include("includes/header.php");

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("location: index.php");
    exit();
}

// DB connection must be present
global $con;

// Get user data
$user_email = $_SESSION['user_email'];
$get_user_query = "SELECT * FROM users WHERE user_email = ?";
$stmt = mysqli_prepare($con, $get_user_query);
mysqli_stmt_bind_param($stmt, "s", $user_email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['user_id'];
    $user_name = $row['user_name'];
    $f_name = $row['f_name'];
    $l_name = $row['l_name'];
    $describe_user = $row['describe_user'];
    $Relationship_status = $row['Relationship'];
    $user_pass = $row['user_pass'];
    $user_country = $row['user_country'];
    $user_gender = $row['user_gender'];
    $user_birthday = $row['user_birthday'];
} else {
    echo "<h3>Error: User not found.</h3>";
    exit();
}
?>
<html>

<head>
    <title>Edit Account Settings</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
        }

        .edit-profile-container {
            max-width: 800px;
            margin: 30px auto;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 40px;
        }

        .edit-profile-title {
            text-align: center;
            font-size: 28px;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .edit-profile-title:after {
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

        .edit-section {
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .section-title {
            font-size: 20px;
            font-weight: 500;
            color: var(--primary-color);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 12px;
            font-size: 22px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: var(--gray-color);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border-radius: var(--border-radius);
            border: 1px solid #e2e8f0;
            transition: var(--transition);
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.16);
            outline: none;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
            padding-right: 2.5rem;
        }

        select.form-control option {
            padding: 8px;
            background-color: white;
            color: var(--dark-color);
        }

        select.form-control option:checked {
            background-color: #ebf8ff;
            color: var(--primary-color);
            font-weight: 500;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            margin-top: 40px;
            gap: 15px;
        }

        .btn {
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

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.4);
            color: white;
        }

        .btn-secondary {
            background-color: #e53e3e;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #c53030;
            color: white;
            transform: translateY(-2px);
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            color: var(--gray-color);
            font-size: 14px;
            margin-top: 8px;
        }

        .checkbox-label input {
            margin-right: 8px;
        }

        .recovery-btn {
            background-color: var(--light-color);
            border: 1px solid #e2e8f0;
            color: var(--gray-color);
            padding: 10px 20px;
            border-radius: var(--border-radius);
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .recovery-btn:hover {
            background-color: #edf2f7;
            border-color: #cbd5e0;
            color: var(--dark-color);
        }

        /* Modal styles */
        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 5px 5px 0 0;
            border-bottom: none;
        }

        .modal-title {
            font-weight: 500;
        }

        .modal-body {
            padding: 25px;
        }

        .modal-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 15px 25px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .edit-profile-container {
                padding: 25px;
            }
            
            .btn-group {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .edit-profile-container {
                padding: 20px;
            }
            
            .edit-profile-title {
                font-size: 24px;
            }
            
            .section-title {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="edit-profile-container">
            <h1 class="edit-profile-title">Account Settings</h1>
            
            <form action="" method="post" enctype="multipart/form-data">
                <!-- Personal Information Section -->
                <div class="edit-section">
                    <h4 class="section-title">
                        <i class="fas fa-user-circle"></i> Personal Information
                    </h4>
                    
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input class="form-control" type="text" name="f_name" required value="<?php echo htmlspecialchars($f_name); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input class="form-control" type="text" name="l_name" required value="<?php echo htmlspecialchars($l_name); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input class="form-control" type="text" name="u_name" required value="<?php echo htmlspecialchars($user_name); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">About You</label>
                        <textarea class="form-control" name="describe_user" rows="3"><?php echo htmlspecialchars($describe_user); ?></textarea>
                    </div>
                    
                    <!-- Relationship Status -->
                    <div class="form-group">
                        <label class="form-label">Relationship Status</label>
                        <select class="form-control" name="Relationship">
                            <?php
                            $relationship_options = [
                                "Single",
                                "In a Relationship",
                                "Engaged",
                                "Married",
                                "Temporary pause in a relationship",
                                "It's Complicated",
                                "Not Looking for Anything"
                            ];
                            if (!in_array($Relationship_status, $relationship_options) && !empty($Relationship_status)) {
                                echo "<option value=\"$Relationship_status\" selected hidden>$Relationship_status</option>";
                            }
                            echo '<option value="">Select Status</option>';
                            foreach ($relationship_options as $option) {
                                $selected = ($Relationship_status == $option) ? 'selected' : '';
                                echo "<option value=\"$option\" $selected>$option</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                <!-- Account Security Section -->
                <div class="edit-section">
                    <h4 class="section-title">
                        <i class="fas fa-shield-alt"></i> Account Security
                    </h4>
                    
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input class="form-control" type="password" name="u_pass" id="mypass" required value="<?php echo htmlspecialchars($user_pass); ?>">
                        <label class="checkbox-label">
                            <input type="checkbox" onclick="show_password()"> Show Password
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="email" name="u_email" required value="<?php echo htmlspecialchars($user_email); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Password Recovery</label>
                        <button type="button" class="recovery-btn" data-toggle="modal" data-target="#accountEditModal">
                            <i class="fas fa-question-circle"></i> Set Recovery Question
                        </button>
                    </div>
                </div>
                
                <!-- Additional Information Section -->
                <div class="edit-section">
                    <h4 class="section-title">
                        <i class="fas fa-info-circle"></i> Additional Information
                    </h4>
                    
                    <!-- Country -->
                    <div class="form-group">
                        <label class="form-label">Country</label>
                        <select class="form-control" name="u_country">
                            <?php
                            $country_options = ["Pakistan", "UK", "China", "Canada", "Australia"];
                            if (!in_array($user_country, $country_options) && !empty($user_country)) {
                                echo "<option value=\"$user_country\" selected hidden>$user_country</option>";
                            }
                            echo '<option value="">Select Country</option>';
                            foreach ($country_options as $country) {
                                $selected = ($user_country == $country) ? 'selected' : '';
                                echo "<option value=\"$country\" $selected>$country</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <!-- Gender -->
                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select class="form-control" name="u_gender">
                            <?php
                            $gender_options = ["Male", "Female", "Other"];
                            if (!in_array($user_gender, $gender_options) && !empty($user_gender)) {
                                echo "<option value=\"$user_gender\" selected hidden>$user_gender</option>";
                            }
                            echo '<option value="">Select Gender</option>';
                            foreach ($gender_options as $gender) {
                                $selected = ($user_gender == $gender) ? 'selected' : '';
                                echo "<option value=\"$gender\" $selected>$gender</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Birthdate</label>
                        <input class="form-control" type="date" name="u_birthday" required value="<?php echo htmlspecialchars($user_birthday); ?>">
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="btn-group">
                    <a href="home.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary" name="update">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Recovery Modal -->
    <div id="accountEditModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
                    <h4 class="modal-title">Set Password Recovery Question</h4>
                </div>
                <div class="modal-body">
                    <form action="recovery.php?id=<?php echo $user_id; ?>" method="post" id="f">
                        <div class="form-group">
                            <label class="form-label">What is your best friend's name?</label>
                            <textarea class="form-control" rows="4" name="content" placeholder="Write your answer"></textarea>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="sub" value="Submit">
                        </div>
                        <p class="help-block" style="color: var(--gray-color); font-size: 13px;">Answer the above question. We'll ask this when you forget your password.</p>
                    </form>
                    <?php
                    if (isset($_POST['sub'])) {
                        $bfn = htmlentities($_POST['content']);
                        if ($bfn == '') {
                            echo "<script>alert('Please enter something')</script>";
                            echo "<script>window.open('edit_profile.php?u_id$user_id', '_self')</script>";
                            exit();
                        } else {
                            $update = "UPDATE users SET recovery_account ='$bfn' WHERE user_id = $user_id";
                            $run = mysqli_query($con, $update);

                            if ($run) {
                                echo "<script>alert('Recovery question set successfully')</script>";
                                echo "<script>window.open('edit_profile.php?u_id$user_id', '_self')</script>";
                            } else {
                                echo "<script>alert('Error while setting recovery question')</script>";
                                echo "<script>window.open('edit_profile.php?u_id$user_id', '_self')</script>";
                                exit();
                            }
                        }
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function show_password() {
            var x = document.getElementById("mypass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>

<?php
if (isset($_POST['update'])) {
    $f_name = htmlentities($_POST['f_name']);
    $l_name = htmlentities($_POST['l_name']);
    $u_name = htmlentities($_POST['u_name']);
    $describe_user = htmlentities($_POST['describe_user']);
    $Relationship_status = htmlentities($_POST['Relationship']);
    $u_pass = htmlentities($_POST['u_pass']);
    $u_email = htmlentities($_POST['u_email']);
    $u_country = htmlentities($_POST['u_country']);
    $u_gender = htmlentities($_POST['u_gender']);
    $u_birthday = htmlentities($_POST['u_birthday']);

    $update = "UPDATE users SET 
                f_name = '$f_name', 
                l_name = '$l_name', 
                user_name = '$u_name', 
                describe_user = '$describe_user', 
                Relationship = '$Relationship_status', 
                user_pass = '$u_pass', 
                user_email = '$u_email', 
                user_country = '$u_country', 
                user_gender = '$u_gender', 
                user_birthday = '$u_birthday' 
              WHERE user_id = '$user_id'";

    $run = mysqli_query($con, $update);

    if ($run) {
        echo "<script>alert('Your Profile Updated')</script>";
        echo "<script>window.open('edit_profile.php?u_id=$user_id', '_self')</script>";
    } else {
        echo "<script>alert('Error updating profile')</script>";
    }
}
?>