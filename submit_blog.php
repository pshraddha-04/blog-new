<?php
// Include database connection file
require 'db_connect.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_signup.php");
    exit;
}

// Fetch the logged-in user's name for author
$username = $_SESSION['username'];
$user_query = "SELECT name FROM users WHERE email = '$username'";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);
$author_name = $user['name'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    
    // Image upload handling
    $image_name = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_error = $_FILES['image']['error'];

    // Insert blog post into the database
    if ($image_error === 0) {
      // Define a target directory to store the image
      $image_destination = 'uploads/' . basename($image_name);
      
      // Move the uploaded file to the destination folder
      if (move_uploaded_file($image_tmp_name, $image_destination)) {
          // Insert blog post with image path into the database
          $sql = "INSERT INTO posts (title, author, content, image) VALUES ('$title', '$author_name', '$content', '$image_name')";
          if (mysqli_query($conn, $sql)) {
              header("Location: index.php");
              exit;
          } else {
              echo "Error: " . mysqli_error($conn);
          }
      } else {
          echo "Failed to upload image.";
      }
  } else {
      echo "Error with image upload.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Blog</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-lg py-3">
    <div class="container">
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

        <!-- <li class="nav-item">
          <a class="nav-link active" href="submit_blog.php">Submit Blog</a>
        </li> -->

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
    <h2 class="text-center">Create a Blog Post</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Blog Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" class="form-control" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Upload Image</label>
            <input type="file" name="image" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-dark">Submit</button>
    </form>
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


<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
