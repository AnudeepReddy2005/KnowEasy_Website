<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            overflow-y: auto;
        }

        .main {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 20px;
            width: 100%;
            max-width: 450px;
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
            text-align: left;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"],
        textarea {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #6c6c6c;
            border-radius: 5px;
            font-size: 14px;
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

        h4, h5 {
            margin: 5px 0;
        }
    </style>
</head>
<body>
<div class="main">
    <h2>Registration Form</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usernames = $_POST['usernames'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $passwords = $_POST['passwords'];
        $places = $_POST['places'];
        $know_desc = $_POST['know_desc'];
        $fee = $_POST['fee'];

        // Upload directories
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Certificate upload
        $certificate_name = $_FILES['certificate']['name'];
        $certificate_tmp = $_FILES['certificate']['tmp_name'];
        $certificate_file = $upload_dir . time() . "_" . basename($certificate_name);
        move_uploaded_file($certificate_tmp, $certificate_file);

        // Profile photo upload
        $profile_photo_name = $_FILES['profile_photo']['name'];
        $profile_photo_tmp = $_FILES['profile_photo']['tmp_name'];
        $profile_photo_file = $upload_dir . time() . "_" . basename($profile_photo_name);
        move_uploaded_file($profile_photo_tmp, $profile_photo_file);

        // DB connection
        $conn = new mysqli("localhost", "root", "", "knoweasy_registration");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO anu (usernames, mobile, email, passwords, places, know_desc, fee, certificate, profile_photo)
                VALUES ('$usernames', '$mobile', '$email', '$passwords', '$places', '$know_desc', '$fee', '$certificate_file', '$profile_photo_file')";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='success-message'>You are successfully registered. Thank you!</div>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>

    <form action="" method="post" enctype="multipart/form-data">
        <label for="username">User Name:</label>
        <input type="text" id="usernames" name="usernames" required placeholder="Please enter your name">

        <label for="mobile">Mobile Number:</label>
        <input type="text" id="mobile" name="mobile" maxlength="10" required placeholder="Enter valid mobile number">

        <label for="email">Email Id:</label>
        <input type="email" id="email" name="email" required placeholder="Enter valid email address">

        <label for="passwords">Password:</label>
        <input type="password" id="passwords" name="passwords"
               pattern="^(?=.*\d)(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9])\S{8,}$"
               required placeholder="Create a strong password">

        <label for="places">Places/Colleges/Universities:</label>
        <input type="text" id="places" name="places" required placeholder="Enter names only, no description">

        <label for="know_desc">How do you know about it?</label>
        <textarea id="know_desc" name="know_desc" rows="4" maxlength="400" placeholder="Describe briefly (~50 words)" required></textarea>

        <label for="fee">Fee Charged:</label>
        <input type="text" id="fee" name="fee" required placeholder="Charge a reasonable amount">

        <label for="certificate">Upload Proof (Valid Certificate):</label>
        <input type="file" id="certificate" name="certificate" accept=".pdf,.jpg,.jpeg,.png" required>

        <label for="profile_photo">Upload Profile Photo:</label>
        <input type="file" id="profile_photo" name="profile_photo" accept=".jpg,.jpeg,.png" required>

        <h4 style="color:red;">NOTE:</h4>
        <h5>Enter only names of the colleges/universities/places in a single word, don't write descriptions.</h5>

        <button type="submit">Submit</button>
    </form>
</div>
</body>
</html>
