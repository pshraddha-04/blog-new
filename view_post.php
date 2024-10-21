<?php
// Include database connection file
require 'db_connect.php';
session_start();

// Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//   header("Location: login_signup.php"); // Redirect to login page if not logged in
//   exit;
// }

// Check if a blog ID is passed in the URL
if (isset($_GET['id'])) {
    $post_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch the blog post from the database
    $sql = "SELECT * FROM posts WHERE id = '$post_id'";
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);

    // Check if the post exists
    if (!$post) {
        echo "<h2>Blog post not found!</h2>";
        exit;
    }
  } else {
          header("Location: index.php");
          exit;
    }

//likes/dislikes 
if (isset($_POST['like']) || isset($_POST['dislike'])) {
  $post_id = $_POST['post_id'];
  $user_id = $_SESSION['user_id'];
  $new_action = isset($_POST['like']) ? 'like' : 'dislike';

  // Check if the user has already liked or disliked the post
  $check_sql = "SELECT action FROM likes_dislikes WHERE user_id = '$user_id' AND post_id = '$post_id'";
  $check_result = mysqli_query($conn, $check_sql);

  if (mysqli_num_rows($check_result) > 0) {
      $row = mysqli_fetch_assoc($check_result);
      $current_action = $row['action'];

      if ($current_action != $new_action) {
          // If the user changes from like to dislike or vice versa
          if ($new_action == 'like') {
              // Decrease dislikes and increase likes
              $update_sql = "UPDATE posts SET dislikes = dislikes - 1, likes = likes + 1 WHERE id = '$post_id'";
          } else {
              // Decrease likes and increase dislikes
              $update_sql = "UPDATE posts SET likes = likes - 1, dislikes = dislikes + 1 WHERE id = '$post_id'";
          }
          mysqli_query($conn, $update_sql);

          // Update the user's action in the `likes_dislikes` table
          $update_action_sql = "UPDATE likes_dislikes SET action = '$new_action' WHERE user_id = '$user_id' AND post_id = '$post_id'";
          mysqli_query($conn, $update_action_sql);
      }

  } else {
      // No previous interaction, insert the new like or dislike
      $insert_sql = "INSERT INTO likes_dislikes (user_id, post_id, action) VALUES ('$user_id', '$post_id', '$new_action')";
      mysqli_query($conn, $insert_sql);

      // Update the post's likes or dislikes count
      if ($new_action == 'like') {
          $update_sql = "UPDATE posts SET likes = likes + 1 WHERE id = '$post_id'";
      } else {
          $update_sql = "UPDATE posts SET dislikes = dislikes + 1 WHERE id = '$post_id'";
      }
      mysqli_query($conn, $update_sql);
  }

  // Redirect back to the blog view page
  header("Location: view_post.php?id=$post_id");
  exit;
}

    // Handle comment submission
    if (isset($_POST['submit_comment']) && isset($_SESSION['username'])) {
      $user_id = $_SESSION['user_id']; // Assuming user ID is stored in session during login
      $comment = mysqli_real_escape_string($conn, $_POST['comment']);

      // Insert the comment into the database
      $sql = "INSERT INTO comments (post_id, user_id, comment) VALUES ('$post_id', '$user_id', '$comment')";
      mysqli_query($conn, $sql);
    }

    // Fetch comments for the blog post
    $comments_sql = "SELECT comments.*, users.name FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = '$post_id' ORDER BY date DESC";
    $comments_result = mysqli_query($conn, $comments_sql);



?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?php echo htmlspecialchars($post['title']); ?>
  </title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <link rel="stylesheet" href="poststyle.css">

  <style></style>

</head>

<body>

  <!-- navigation bar -->
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


  <!-- Blog Post Content -->
  <div class="container blog-content">
    <div class="row">
      <div class="col-md-12">
        <h1 class="blog-title">
          <?php echo htmlspecialchars($post['title']); ?>
        </h1>
        <p class="blog-author">By
          <?php echo htmlspecialchars($post['author']); ?> on
          <?php echo date("F j, Y", strtotime($post['date'])); ?>
        </p>

        <!-- Display the blog image -->
        <?php if (!empty($post['image'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>" class="blog-image mb-4" alt="Blog Image">
        <?php endif; ?>

        <!-- Blog content -->
        <div class="blog-body">
          <p>
            <?php echo nl2br(htmlspecialchars($post['content'])); ?>
          </p>
        </div>

        <div class="blog-interaction">
          <form method="POST" action="">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">

            <!-- Like Button with Heart Icon -->
            <button type="submit" name="like" class="btn btn-heart" <?php echo isset($_SESSION['user_id']) ? ''
              : 'disabled' ; ?>>
              <i class="fas fa-heart"></i> (
              <?php echo $post['likes']; ?>)
            </button>

            <!-- Dislike Button with Broken Heart Icon -->
            <button type="submit" name="dislike" class="btn btn-broken-heart" <?php echo isset($_SESSION['user_id'])
              ? '' : 'disabled' ; ?>>
              <i class="fas fa-heart-broken"></i> (
              <?php echo $post['dislikes']; ?>)
            </button>

            <!-- <p class="mt-3">You must be logged in to like/dislike a post. <a href="login_signup.php">Login here</a>.</p> -->

          </form>
        </div>

        



        <!-- Comments Section -->
        <div class="comment-section">
          <h4>Comments</h4>

          <!-- Display comments -->
          <?php while ($comment = mysqli_fetch_assoc($comments_result)): ?>
          <div class="comment">
            <strong>
              <?php echo htmlspecialchars($comment['name']); ?>
            </strong>
            <p>
              <?php echo nl2br(htmlspecialchars($comment['comment'])); ?>
            </p>
            <small class="text-muted">Posted on
              <?php echo date("F j, Y", strtotime($comment['date'])); ?>
            </small>
          </div>
          <?php endwhile; ?>

          <!-- Comment Form -->
          <?php if (isset($_SESSION['username'])): ?>
          <form method="POST" class="mt-4">
            <div class="form-group">
              <label for="comment">Add a Comment:</label>
              <textarea name="comment" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" name="submit_comment" class="btn btn-dark">Submit Comment</button>
          </form>
          <?php else: ?>
          <p class="mt-3">You must be logged in to leave a comment. <a href="login_signup.php">Login here</a></p>
          <?php endif; ?>
        </div>

        <!-- Back to home button -->
        <a href="index.php" class="btn btn-dark mt-3">Back to Home</a>
      </div>
    </div>
  </div>

  <br><br><br><br>
  <!-- Footer -->
<!-- Footer -->
<footer class="text-center p-3 footer-color">
  <section class="social-icons text-center mb-3">
      <h5>Connect with Us</h5>
      <a href="#"><i class="fw-bold fab fa-facebook-f"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
  </section>
    <p>&copy; 2024 ExploreX. All rights reserved.</p>
</footer>

  <!-- jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>

</html>