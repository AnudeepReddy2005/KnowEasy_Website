<?php
// Start the session
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// Check if the ID is provided
if (isset($_GET['id'])) {
    // Get the user ID
    $user_id = $_GET['id'];

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "knoweasy_registration");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete the user from the database
    $sql = "DELETE FROM anu WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Successfully deleted the user
        echo "<script>alert('User has been rejected and removed from the database.');</script>";
        header("Location: verify_users.php"); // Redirect back to the verify users page
    } else {
        echo "<script>alert('Error rejecting the user.');</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid user ID.";
}
?>
