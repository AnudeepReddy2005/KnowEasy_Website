<?php
session_start();

// Direct DB connection
$conn = new mysqli("localhost", "root", "", "knoweasy_registration");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM anu WHERE id = $user_id";  // Assuming your table is 'anu'
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .profile-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        h1 {
            color: #4f46e5;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            background: #4f46e5;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            transition: background 0.3s ease;
        }

        a:hover {
            background: #3730a3;
        }
    </style>
</head>
<body>

<div class="profile-box">
    <h1>Welcome, <?php echo htmlspecialchars($user['usernames']); ?></h1>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Mobile:</strong> <?php echo htmlspecialchars($user['mobile']); ?></p>
    <p><strong>Place:</strong> <?php echo htmlspecialchars($user['places']); ?></p>
    <p><strong>Fee:</strong> ₹<?php echo htmlspecialchars($user['fee']); ?></p>

    <a href="edit_profile.php">Edit Profile</a>
    <br>
    <a href="logout.php">Logout</a>
</div>

</body>
</html>

