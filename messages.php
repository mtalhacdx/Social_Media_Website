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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="row">
        <?php
        if (isset($_GET['u_id'])) {
            global $con;
            $get_id = $_GET['u_id'];
            $get_user = "SELECT * FROM users WHERE user_id = '$get_id'";
            $run_user = mysqli_query($con, $get_user);
            $row_user = mysqli_fetch_array($run_user);

            if ($row_user) {  // Check if user exists
                $user_to_msg = $row_user['user_id'];
                $user_to_name = $row_user['user_name'];
            }
        }

        $user = $_SESSION['user_email'];
        $get_user = "SELECT * FROM users WHERE user_email = '$user'";  // Fixed typo: user_emil -> user_email
        $run_user = mysqli_query($con, $get_user);
        $row_user = mysqli_fetch_array($run_user);

        if ($row_user) {  // Check if user exists before accessing array
            $user_from_msg = $row_user['user_id'];
            $user_from_name = $row_user['user_name'];
        }
        ?>

        <div class="col-sm-3" id="select_user">
            <?php
            $user = "SELECT * FROM users";
            $run_user = mysqli_query($con, $user);

            while ($row_user = mysqli_fetch_array($run_user)) {
                $user_id = $row_user['user_id'];
                $user_name = $row_user['user_name'];
                $first_name = $row_user['f_name'];
                $last_name = $row_user['l_name'];
                $user_image = $row_user['user_image'];

                echo "
                <div class='container-fluid'>
                    <a href='messages.php?u_id=$user_id' style='text-decoration:none; cursor:pointer; color:#3897f0'>
                        <img class='image-circle' src='users/$user_image' height='90px' width='80px' title='$user_name'>
                        <strong>&nbsp $first_name $last_name</strong><br><br>
                    </a>
                </div>";
            }
            ?>
        </div>

        <div class="col-sm-6">
            <div class="load_msg" id="scroll_msg">
                <?php
                if (isset($user_to_msg) && isset($user_from_msg)) {
                    $sel_msg = "SELECT * FROM user_messages WHERE (user_to='$user_to_msg' AND user_from='$user_from_msg') OR (user_from='$user_to_msg' AND user_to='$user_from_msg') ORDER BY 1 ASC";
                    $run_msg = mysqli_query($con, $sel_msg);

                    while ($row_msg = mysqli_fetch_array($run_msg)) {
                        $user_to = $row_msg['user_to'];
                        $user_from = $row_msg['user_from'];
                        $msg_body = $row_msg['msg_body'];
                        $msg_date = $row_msg['date'];
                        ?>
                        <div id="loaded_msg"> 
                            <p>
                                <?php
                                if ($user_to == $user_to_msg && $user_from == $user_from_msg) {
                                    echo "<div class='message' id='blue' data-toggle='tooltip' title='$msg_date'>$msg_body</div><br><br><br>";
                                } elseif ($user_from == $user_to_msg && $user_to == $user_from_msg) {
                                    echo "<div class='message' id='green' data-toggle='tooltip' title='$msg_date'>$msg_body</div><br><br><br>";
                                }
                                ?>
                            </p>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>