           <?php include("signin.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Responsive Login | SnapCircle</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="Bootstrap/Bootstrap.css">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- Custom CSS  -->

<style>
      html,
    body {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #eee;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container-box {
      display: flex;
      width: 90%;
      max-width: 900px;
      height: 65vh;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      background: white;
    }

    .form-side,
    .info-side {
      flex: 1;
      padding: 2rem;
      overflow-y: auto;
    }

    .form-side {
      background-color: #fff;
    }

    .info-side {
      background: linear-gradient(135deg, #4361ee, #3f37c9);
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .info-side h3 {
      font-weight: bold;
      font-size: 24px;
    }

    .info-side p {
      font-size: 14px;
      margin-top: 10px;
    }

    h2 {
      margin-bottom: 20px;
      margin-left: 40px;
      font-weight: bold;
      color: #4361ee;
    }

    .form-label {
      font-size: 14px;
      margin-bottom: 4px;
    }

    .input-group-text {
      background-color: #f1f1f1;
      font-size: 14px;
    }

    .form-control:focus {
      border-color: #4361ee;
      box-shadow: none;
    }

    .btn-custom {
      background: #3f37c9;
      color: #fff;
      transition: .3s;
      padding: 10px;
      font-size: 1rem;
      font-weight: bold;
      border-radius: 15px;
    }

    .btn-custom:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
       background:rgb(67, 60, 207);
    }

    .toggle-password {
      cursor: pointer;
    }

    small a {
      color: #3f37c9;;
      text-decoration: none;
    }

    @media screen and (max-width: 768px) {
      .container-box {
        flex-direction: column;
        height: auto;
      }

      .info-side {
        padding: 2rem 1rem;
      }
    }
</style>
 

</head>

<body>

  <div class="container-box">
    <!-- LEFT: LOGIN FORM -->
    <div class="form-side">
      <h2>Welcome Back</h2>
      <form method="POST" action="login.php">

        <div class="mb-3">
          <label class="form-label">Email</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" class="form-control" name="email" placeholder="Email address" required />
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" class="form-control" name="pass" id="loginPassword" placeholder="Password" required />
            <span class="input-group-text toggle-password"><i class="fas fa-eye" id="loginToggleIcon"></i></span>
          </div>
        </div>

        <div class="mb-2 text-end">
          <small><a href="forget_password.php">Forgot Password?</a></small>
        </div>

        <div class="d-grid mb-3">
          <button type="submit" class="btn btn-custom" name="login">Login</button>
        </div>

        <div class="text-center">
          <small>Don't have an account? <a href="signup.php">Sign up</a></small>
        </div>
  
      </form>
    </div>

    <!-- RIGHT: WELCOME TEXT -->
    <div class="info-side">
      <h3>Hello, again!</h3>
      <p>To keep connected with us, please login with your personal info.</p>
    </div>
  </div>

  <!-- JS -->
  <script src="Custom-js/login.js"></script>
  <script src="Bootstrap/Bootstrap.js"></script>
  <script>
    const toggleLoginPassword = document.querySelector('.toggle-password');
    const loginPasswordField = document.getElementById('loginPassword');
    const loginToggleIcon = document.getElementById('loginToggleIcon');

    toggleLoginPassword.addEventListener('click', function() {
      const type = loginPasswordField.type === 'password' ? 'text' : 'password';
      loginPasswordField.type = type;
      loginToggleIcon.classList.toggle('fa-eye');
      loginToggleIcon.classList.toggle('fa-eye-slash');
    });
  </script>
</body>

</html>