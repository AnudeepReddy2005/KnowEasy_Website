<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Form</title>
    <script>
        function confirmLogout(){
            return confirm("Are you sure you want to logout ?\n\n You will no longer have access to this website.");
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .main {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 20px;
            width: 400px;
            text-align: center;
        }

        .main h2 {
            color: #181845;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #444;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #6c6c6c;
            border-radius: 5px;
        }

        button[type="submit"] {
            padding: 15px;
            border-radius: 10px;
            border: none;
            background-color: #181845;
            color: white;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            padding: 10px;
            margin-top: 20px;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="main">
        <h2>Delete Account Form</h2>
        <?php
        // Database connection parameters
        $hostname = 'localhost'; // Replace with your host name
        $username = 'root'; // Replace with your database username
        $password = ''; // Replace with your database password
        $database = 'knoweasy_registration'; // Replace with your database name

        // Establish database connection
        $conn = new mysqli($hostname, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usernames = $_POST['usernames'];
            $passwords = $_POST['passwords'];

            // SQL injection prevention (optional)
            $username = mysqli_real_escape_string($conn, $usernames);
            $password = mysqli_real_escape_string($conn, $passwords);

            // Query to check if username and password match
            $sql = "SELECT * FROM anu WHERE usernames = '$username' AND passwords = '$password'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Delete the record
                $delete_sql = "DELETE FROM anu WHERE usernames = '$username' AND passwords = '$password'";
                if ($conn->query($delete_sql) === TRUE) {
                    // Record deleted successfully
                    echo "<div class='success-message'>Record deleted successfully. You are logged out.</div>";
                } else {
                    echo "<div class='error-message'>Error deleting record: " . $conn->error . "</div>";
                }
            } else {
                echo "<div class='error-message'>Your details are incorrect.</div>";
            }
        }

        // Close connection
        $conn->close();
        ?>
        <form action="" method="post" onsubmit="return confirmLogout();">
            <label for="username">User Name:</label>
            <input type="text" id="usernames" name="usernames" required placeholder="Please enter your name">

            <label for="password">Password:</label>
            <input type="password" id="passwords" name="passwords" pattern="^(?=.*\d)(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9])\S{8,}$" placeholder="Please enter your password" required>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
