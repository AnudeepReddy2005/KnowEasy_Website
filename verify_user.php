<?php
// Start the session
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// Connect to the database
$conn = new mysqli("localhost", "root", "", "knoweasy_registration");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verify the user
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Query to update the user's verification status
    $sql = "UPDATE anu SET verified = 1 WHERE id = $user_id";

    if ($conn->query($sql) === TRUE) {
        echo "User verified successfully!";
        header("Location: admin_panel.php");  // Redirect back to the admin panel after verification
    } else {
        echo "Error: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
