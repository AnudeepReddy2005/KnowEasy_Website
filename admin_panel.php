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

// Fetch all unverified users
$sql = "SELECT * FROM anu WHERE verified = 0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Verify Users</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 90%;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4f46e5;
            color: white;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        .verify-btn, .reject-btn {
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 5px;
            text-decoration: none;
            display: inline-block;
        }

        .verify-btn {
            background-color: #4caf50;
            color: white;
        }

        .verify-btn:hover {
            background-color: #45a049;
        }

        .reject-btn {
            background-color: #e53935;
            color: white;
        }

        .reject-btn:hover {
            background-color: #c62828;
        }

        .back-btn {
            display: block;
            text-align: center;
            margin-top: 30px;
            padding: 10px;
            background-color: #4f46e5;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            width: 200px;
            margin: 20px auto;
        }

        .back-btn:hover {
            background-color: #3730a3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Panel - Verify Users</h2>

        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Place</th>
                <th>How do you know?</th>
                <th>Fee</th>
                <th>Certificate</th>
                <th>Actions</th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Get the relative path of the certificate (stored as 'uploads/filename.pdf')
                    $relativePath = $row['certificate']; // e.g. 'uploads/1746059980_TGSRTC BUS PASS anu.pdf'

                    // Define the base URL for the certificate (publicly accessible folder)
                    $certificateURL = "/uploads/" . urlencode(basename($relativePath)); // Properly URL-encode the filename

                    // Check if the file exists on the server
                    $serverFilePath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . basename($relativePath);
                    echo "<!-- Debug: Server file path: $serverFilePath -->";  // Debugging line

                    if (file_exists($serverFilePath)) {
                        $certificateLink = "<a href='$certificateURL' target='_blank'>View Certificate</a>";
                    } else {
                        $certificateLink = "<span style='color:red;'>File not found</span>";
                    }

                    // Output each user's data in the table
                    echo "<tr>
                        <td>{$row['usernames']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['mobile']}</td>
                        <td>{$row['places']}</td>
                        <td>{$row['know_desc']}</td>
                        <td>{$row['fee']}</td>
                        <td>$certificateLink</td>
                        <td>
                            <a href='verify_user.php?id={$row['id']}'><button class='verify-btn'>Verify</button></a>
                            <a href='reject_user.php?id={$row['id']}'><button class='reject-btn'>Reject</button></a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No unverified users found.</td></tr>";
            }
            ?>
        </table>

        <a href="admin_logout.php" class="back-btn">Logout</a>
    </div>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
