<?php
session_start();

// DB connection
$conn = new mysqli("localhost", "root", "", "knoweasy_registration");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Session check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch current user data
$stmt = $conn->prepare("SELECT * FROM anu WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernames = trim($_POST['usernames']);
    $mobile = trim($_POST['mobile']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // will store as plain text
    $places = trim($_POST['places']);
    $know_desc = trim($_POST['know_desc']);
    $fee = trim($_POST['fee']);
    $certificate = $user['certificate']; // default to current value

    // File upload handling
    if (!empty($_FILES['certificate']['name'])) {
        $target_dir = "uploads/";
        $filename = basename($_FILES["certificate"]["name"]);
        $target_file = $target_dir . time() . "_" . $filename;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allowed file types
        $allowed = ['pdf', 'jpg', 'jpeg', 'png'];
        if (!in_array($file_type, $allowed)) {
            $error = "Only PDF, JPG, JPEG, and PNG files are allowed.";
        } else {
            if (move_uploaded_file($_FILES["certificate"]["tmp_name"], $target_file)) {
                $certificate = $target_file;
            } else {
                $error = "Error uploading file.";
            }
        }
    }

    if (!isset($error) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    }

    if (!isset($error)) {
        if (!empty($password)) {
            $plain_password = $password; // store as plain text (not hashed)
            $sql = "UPDATE anu SET usernames=?, mobile=?, email=?, passwords=?, places=?, know_desc=?, fee=?, certificate=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssi", $usernames, $mobile, $email, $plain_password, $places, $know_desc, $fee, $certificate, $user_id);
        } else {
            $sql = "UPDATE anu SET usernames=?, mobile=?, email=?, places=?, know_desc=?, fee=?, certificate=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssi", $usernames, $mobile, $email, $places, $know_desc, $fee, $certificate, $user_id);
        }

        if ($stmt->execute()) {
            $_SESSION['message'] = "Profile updated successfully.";
            header("Location: profile.php");
            exit;
        } else {
            $error = "Error updating profile: " . $stmt->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .edit-profile-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 420px;
        }

        h1 {
            color: #4f46e5;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        input[type="submit"] {
            background: #4f46e5;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            margin-top: 20px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background: #3730a3;
        }

        .error {
            color: red;
            margin-top: 10px;
            text-align: center;
        }

        .success-message {
            color: green;
            margin-top: 10px;
            text-align: center;
        }

        p {
            margin: 0;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="edit-profile-box">
    <h1>Edit Profile</h1>

    <?php
    if (isset($error)) {
        echo "<p class='error'>$error</p>";
    }
    if (isset($_SESSION['message'])) {
        echo "<p class='success-message'>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message']);
    }
    ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <label>Username:</label>
        <input type="text" name="usernames" value="<?php echo htmlspecialchars($user['usernames']); ?>" required>

        <label>Mobile:</label>
        <input type="text" name="mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label>New Password (leave blank to keep current):</label>
        <input type="password" name="password" placeholder="Enter new password">

        <label>Place:</label>
        <input type="text" name="places" value="<?php echo htmlspecialchars($user['places']); ?>" required>

        <label>Knowledge Description:</label>
        <input type="text" name="know_desc" value="<?php echo htmlspecialchars($user['know_desc']); ?>" required>

        <label>Fee:</label>
        <input type="text" name="fee" value="<?php echo htmlspecialchars($user['fee']); ?>" required>

        <label>Certificate (Upload New File):</label>
        <input type="file" name="certificate">
        <p>Current: <?php echo htmlspecialchars(basename($user['certificate'])); ?></p>

        <input type="submit" value="Update Profile">
    </form>
</div>

</body>
</html>
