<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knoweasy Help Page</title>
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

        .container {
            background-color: #fff;
            border: 4px solid #000;
            border-radius: 10px;
            width: 80%;
            max-width: 800px;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #13134d;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: blue;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .button:hover {
            background-color: blueviolet;
        }

        h2 {
            color: #13134d;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        p {
            color: #333;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        h6 {
            color: blueviolet;
            margin-bottom: 10px;
        }

        .note {
            color: red;
        }

        ul {
            text-align: left;
            margin-left: 30px;
        }

        a {
            color: blue;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Help Page</h1>
        <a href="mailto:chittepuanudeep01@gmail.com" class="button">Mail Us</a>
        <h6>If you have any doubts, click the button above to email us.</h6>

        <p>Here are a few steps to understand how to use this website:</p>

        <h2>Step 1: Create Account</h2>
        <p>Create an account by providing necessary details such as username, age, address, mobile number, email, etc. Click the button below to get started.</p>
        <p>Create a strong password while creating your account.</p>

        <div class="note">
            <h2>Note:</h2>
            <ul>
                <li>You must enter genuine information during account creation.</li>
                <li>Provide accurate details about universities, places, colleges, etc., that you know.</li>
                <li>Charge a reasonable amount for providing information to attract more customers.</li>
            </ul>
        </div>

        <h2>Step 2: Login</h2>
        <p>Login to your account to modify your details. Click the button below to proceed.</p>

        <h2>Step 3: Logout</h2>
        <p>Logout and completely delete your account. Click the button below to logout.</p>

        <a href="homepage.html" class="button">Home</a>
        <p>Click here to return to the home page.</p>
    </div>
</body>
</html>
