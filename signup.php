<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Responsive Sign Up | SnapCircle</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="Bootstrap/Bootstrap.css">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- custom css  -->
  <link rel="stylesheet" href="Custom-CSS/signup.css?v=1.0">

  
</head>

<body>



  <div class="container-box">
    <!-- LEFT: SIGN UP FORM -->
    <div class="form-side">
      <h2>Create Account</h2>


      <form method="POST" action="signup.php">

        <div class="mb-2">
          <label class="form-label">First Name</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" class="form-control" name="first_name" placeholder="First name" required />
          </div>
        </div>

        <div class="mb-2">
          <label class="form-label">Last Name</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" class="form-control" name="last_name" placeholder="Last name" required />
          </div>
        </div>

        <div class="mb-2">
          <label class="form-label">Email</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" class="form-control" name="u_email" placeholder="Email address" required />
          </div>
        </div>

        <div class="mb-2">
          <label class="form-label">Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" class="form-control" id="password" name="u_pass" placeholder="Password" required />
            <span class="input-group-text toggle-password"><i class="fas fa-eye" id="toggleIcon"></i></span>
          </div>
        </div>

        <div class="mb-2">
          <label class="form-label">Country</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-globe"></i></span>
            <select class="form-select" name="u_country">
              <option selected disabled>Choose country</option>
              <option>Pakistan</option>
              <option>UK</option>
              <option>China</option>
              <option>Canada</option>
              <option>Australia</option>
            </select>
          </div>
        </div>

        <div class="mb-2">
          <label class="form-label">Gender</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
            <select class="form-select" name="u_gender">
              <option selected disabled>Choose gender</option>
              <option>Male</option>
              <option>Female</option>
              <option>Other</option>
            </select>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Date of Birth</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
            <input type="date" class="form-control" name="u_birthday" required />
          </div>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-custom" name="signup">Create Account</button>
          <?php include("insert_user.php"); ?>
        </div>

        <div class="mt-3 text-center">
          <small>Already have an account? <a href="login.php">Sign in</a></small>

        </div>
      </form>
    </div>

    <!-- RIGHT: WELCOME TEXT -->
    <div class="info-side">
      <h3>Hello, friend!</h3>
      <p>Glad to see you! Enter your personal details and start your journey with us.</p>
    </div>
  </div>

  <!-- JS -->
  <script src="Custom-js/signup.js"></script>
  <script src="Bootstrap/Bootstrap.js"></script>

</body>

</html>