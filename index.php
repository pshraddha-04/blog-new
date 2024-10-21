<?php
// Include database connection file
require 'db_connect.php';

// Start session to access logged-in user info
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Fetch user details from the database
    $user_query = "SELECT name FROM users WHERE email = '$username'";
    $user_result = mysqli_query($conn, $user_query);
    $user = mysqli_fetch_assoc($user_result);
    $author_name = $user['name']; // Fetch the user's name
}

// Fetch blog posts from the database
$sql = "SELECT * FROM posts ORDER BY date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ExploreX | Discover, Explore and Share! </title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="style.css">


</head>

<body>

  <!-- Navigation Bar -->
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

        <li class="nav-item">
          <a class="nav-link active" href="submit_blog.php">Create Post</a>
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

  <!-- Page Content -->
  <div class="container my-5">
    <!-- <h1 class="text-center mb-4">Welcome to My Blog</h1> -->
    <div class="row" id="blog-posts">

    <div class="jumbotron text-center my-4" style="background-color: #f8f9fa; padding: 30px; border-radius: 10px;">
    <h1 class="display-4" style="font-weight: bold;">Unleash Your Inner Explorer!</h1>
    <p class="lead">From breathtaking landscapes to hidden gems, join fellow travelers in sharing experiences that inspire and ignite curiosity. Let your voice be heard! Share your stories and inspire others to explore the unknown.</p>
    <hr class="my-4">
    <p>Whether you're here for thought-provoking articles, insightful tips, or just to satisfy your reading cravings, there's something for everyone.</p>
    <!-- <a class="btn btn-primary btn-lg" href="#blog-posts" role="button">Explore Now</a> -->
</div>

      <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
                <div class='col-md-4 mb-4'>
                    <div class='card blog-card'>
                        <img src='uploads/" . $row['image'] . "' class='card-img-top' alt='Blog Image'>
                        <div class='card-body'>
                            <h5 class='card-title'>" . htmlspecialchars($row['title']) . "</h5>
                            <p class='card-text'>" . htmlspecialchars(substr($row['content'], 0, 100)) . "...</p>
                            <p class='text-muted'>By " . htmlspecialchars($row['author']) . " on " . date("F j, Y", strtotime($row['date'])) . "</p>
                            <a href='view_post.php?id=" . $row['id'] . "' class='btn btn-dark'>Read More</a>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "<p class='text-center'>No blog posts available at the moment. Please check back later!</p>";
        }
        ?>

    </div>
  </div>


<!-- <div class="container my-5">
    <div class="row">
        <div class="col text-center">
            <h2 class="font-weight-bold">Loved Our Blogs?</h2>
            <p class="lead">There's more where that came from! Stay tuned for new posts, fresh ideas, and exclusive content that will inspire and empower you.</p>
            <a href="submit_blog.php" class="btn btn-outline-dark btn-lg">Share Your Thoughts!</a>
            <p class="mt-4">We’re always looking for new voices and ideas. Join our community by sharing your own stories and insights with the world.</p>
        </div>
    </div>
</div> -->

<!-- Border Hero Section Below Blog Posts -->
<section class="hero border-hero my-5 py-5">
    <div class="container hero-container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3 class="display-4 font-weight-bold">Travel Far...<br> Share Wide!</h3>
                <!-- <h1 class="display-4 font-weight-bold">Explore. Dream. Discover.</h1> -->
                <p class="lead">Join a community of passionate travelers, share your adventures, and connect with fellow explorers. Discover inspiring travel stories and tips from bloggers around the world.</p>
                <!-- <button type="button" class="btn btn-primary btn-lg me-2">Get Started</button> -->
                <a href="login_signup.php" class="btn btn-dark btn-lg me-2">Get Started</a>
                <!-- <button type="button" class="btn btn-outline-secondary btn-lg">Learn More</button> -->
            </div>
            <div class="col-md-6 d-none d-md-block">
                <img src="discover.png" alt="Hero Image" class="img-fluid rounded shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- accordion -->
<h2 class="text-center">Frequently Asked Questions </h2>

<div class="d-flex justify-content-center mb-5"> 
  <div class="accordion accordion-flush w-75  shadow-sm" id="accordionFlushExample">
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-headingOne">
        <button class="accordion-button collapsed shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        How do I start a blog on this platform?
        </button>
      </h2>
      <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">Sign up for an account, log in, and go to the "Create Post" section to write and publish your blog.</div>
      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-headingTwo">
        <button class="accordion-button collapsed shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
        Can I edit or delete my blog post after publishing it?
        </button>
      </h2>
      <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">No, once a blog post is published, it cannot be edited or deleted. Make sure to review your content before posting.</div>
      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-headingThree">
        <button class="accordion-button collapsed shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
        How do I get more engagement on my blog posts?
        </button>
      </h2>
      <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">To increase engagement, write captivating content, use eye-catching images. Regularly posting fresh content can also help attract more readers and interactions.</div>
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


  <!-- jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>



</body>

</html>