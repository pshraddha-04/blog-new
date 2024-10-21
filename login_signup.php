<?php
// Include database connection file
require 'db_connect.php';

// Start session for login handling
session_start();

// Initialize variables for login and signup
$error = "";
$success_msg = "";

// Handle the login process
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check user credentials
    $sql = "SELECT * FROM users WHERE email='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result); // Fetch the user data
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $row['id']; // Add this line here to store user_id
        $_SESSION['name'] = $row['name'];  // Store user name in session
        header("Location: index.php"); // Redirect to home page after login
    } else {
        $error = "Invalid username or password.";
    }

    $_SESSION['user_id'] = $row['id']; // Add this line in your login logic
}

// Handle the signup process
if (isset($_POST['signup'])) {
  $name = mysqli_real_escape_string($conn, $_POST['name']); // New field for name
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

  
  // Check if passwords match
  if ($password !== $confirm_password) {
      $error = "Passwords do not match.";
  } else {
      // Insert new user into the database
      $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
      if (mysqli_query($conn, $sql)) {
          $success_msg = "Registration successful! You can now log in.";
      } else {
          $error = "Error: " . mysqli_error($conn);
      }
  }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="loginstyle.css">
    <!-- Custom CSS for styling -->

</head>
<body>

<!-- navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-lg py-3">
    <div class="container mt-1">
    <a class="navbar-brand fw-bold" href="#">
    <img src="logo.png" alt="Logo" width="40" height="40" class="d-inline-block align-middle mr-2">
    ExploreX
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">

        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link active" href="submit_blog.php">Submit Blog</a>
        </li>

        <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Display the User's Name and Logout Option if Logged In -->
        <li class="nav-item dropdown">
          <a class="nav-link active dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle"></i>
            <?php echo htmlspecialchars($_SESSION['name']); ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
        <?php else: ?>
        <!-- Display Login Option if User is Not Logged In -->
        <li class="nav-item">
          <a class="nav-link active" href="login_signup.php">Login</a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
    </div>
</nav>

<div class="container my-5">
    <div class="row mt-5">
        <div class="col text-center mt-5">
            <h2 class="font-weight-bold">Join Our Community!</h2>
            <p class="lead text-muted">Become a part of an ever-growing community of thinkers, creators, and innovators. Whether you’re here to share your stories or learn something new, you're in the right place.</p>
            <!-- <p class="text-muted">Already have an account? Log in or sign up today!</p> -->
            <!-- <img src="community.jpg" alt="Community" class="img-fluid my-4"> -->
        </div>
    </div>
</div>


<div class="container">
    <h2 class="text-center mb-3">Login & Signup</h2>
    
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card p-4">
                <h4>Login</h4>
                <?php if (isset($_POST['login']) && $error): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-dark">Login</button>
                </form>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card p-4">
                <h4>Signup</h4>
                <?php if (isset($_POST['signup']) && $error): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if ($success_msg): ?>
                    <div class="success"><?php echo $success_msg; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" name="signup" class="btn btn-md btn-dark">Signup</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="text-center p-2 footer-color">
  <section class="social-icons text-center mb-1">
    <h5>Connect with Us</h5>
    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
  </section>
  <p>&copy; 2024 ExploreX. All rights reserved.</p>
</footer>


<!-- jQuery and Bootstrap JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



