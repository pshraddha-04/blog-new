<?php
// Database connection details
$servername = "localhost"; // Usually localhost for local server
$username = "root";        // Default username for XAMPP is root
$password = "";            // Default password for XAMPP is empty
$dbname = "new_blog";    // Name of the database you created

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
