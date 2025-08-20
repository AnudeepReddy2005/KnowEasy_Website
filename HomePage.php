<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>KnowEasy | Discover Knowledge</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Inter', sans-serif;
      background:#708090;
      color: #e0e0e0;
    }
    a {
      text-decoration: none;
      color: inherit;
    }
    header {
      background: black;
      color: #ffffff;
      padding: 30px 20px;
      text-align: center;
      height:20vh;
      border-bottom: 4px solid #06b6d4;
    }
    header h1 {
      font-size: 2.8rem;
      font-weight: 600;
    }
    header p {
      color: #a0aec0;
      font-size: 1rem;
      margin-top: 5px;
    }
    nav {
      display: flex;
      justify-content: center;
      background: #1a1a1a;
      padding: 12px 0;
      gap: 30px;
      border-bottom: 1px solid #2d3748;
    }
    nav a {
      color: #ffffff;
      font-weight: 500;
      font-size: 1rem;
      padding: 6px 12px;
      transition: background 0.3s, color 0.3s;
    }
    nav a:hover {
      color: #06b6d4;
    }
    .container {
      max-width: 1200px;
      margin: 50px auto;
      padding: 0 20px;
    }
    .search-section {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 40px;
      flex-wrap: wrap;
    }
    .search-section input[type="search"] {
      padding: 12px 20px;
      width: 65vw;
      border: 3px solid #4f46e5;
      border-radius: 6px;
      background: #1a1a1a;
      color: #ffffff;
      font-size: 1rem;
    }
    .search-section button {
      background-color: #06b6d4;
      border: none;
      padding: 12px 24px;
      border-radius: 6px;
      color: white;
      font-size: 1rem;
      cursor: pointer;
    }
    .actions {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
      margin-bottom: 30px;
    }
    .actions a {
      background-color: #4f46e5;
      color: white;
      padding: 12px 25px;
      border-radius: 8px;
      font-weight: 500;
    }
    .admin-login {
      text-align: center;
      margin-bottom: 40px;
      font-size: 0.95rem;
    }
    .admin-login a {
      color: #06b6d4;
      text-decoration: underline;
    }
    .results {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    .result-item {
      background-color: #696969;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
      transition: 0.3s;
      display: flex;
      gap: 20px;
      align-items: flex-start;
      flex-wrap: wrap;
    }
    .result-item:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
    }
    .result-item img {
      border-radius: 10px;
      border: 2px solid #fff;
      max-width: 150px;
      height: auto;
    }
    .result-text {
      flex: 1;
      color: #fff;
    }
    .result-item h3 {
      color: black;
      font-size: 1.4rem;
      margin-bottom: 8px;
    }
    .result-item p {
      font-size: 0.95rem;
      color: #f0f0f0;
      margin-bottom: 6px;
    }
    .result-item a {
      display: inline-block;
      margin-top: 10px;
      background-color: #06b6d4;
      color: white;
      padding: 8px 16px;
      border-radius: 6px;
      font-size: 0.9rem;
    }
    footer {
      margin-top: 60px;
      background-color: #4f46e5;
      color: white;
      text-align: center;
      padding: 20px;
      font-size: 0.9rem;
    }
    footer marquee {
      color: #a5f3fc;
      margin-top: 10px;
    }
    @media (max-width: 768px) {
      .search-section input[type="search"],
      .search-section button {
        width: 100%;
      }
      .actions {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
</head>
<body>

<header>
  <h1>KnowEasy</h1>
  <p>NAVIGATING KNOWLEDGE NETWORKS</p>
</header>

<nav>
  <a href="realprojecthome2.php">Home</a>
  <a href="realprojecthelp.php">Help</a>
</nav>

<div class="container">
  <div class="search-section">
    <form method="post" style="display: flex; gap: 10px; width: 100%; flex-wrap: wrap;">
      <input type="search" name="search_term" placeholder="Search by university/college" required>
      <button type="submit">Search</button>
    </form>
  </div>

  <div class="actions">
    <a href="advanceregi1.php">Create Account</a>
    <a href="advanceregi2.php">Modify Account</a>
    <a href="realprojectlogout1.php">Delete Account</a>
  </div>

  <div class="admin-login">
    <p>Are you the admin? <a href="admin_login.php">Log in here</a></p>
  </div>

  <div class="results">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $search_term = trim($_POST["search_term"]);
        if (!empty($search_term)) {
            $conn = new mysqli("localhost", "root", "", "knoweasy_registration");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("SELECT usernames, email, mobile, places, fee, profile_photo, know_desc FROM anu WHERE places LIKE ? AND verified = 1");
            $like = "%$search_term%";
            $stmt->bind_param("s", $like);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<h2 style='color:white;'>Search Results</h2>";
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='result-item'>
                            <img src='" . htmlspecialchars($row["profile_photo"]) . "' alt='Profile Photo'>
                            <div class='result-text'>
                                <h3>" . htmlspecialchars($row["usernames"]) . "</h3>
                                <p><strong>Email:</strong> " . htmlspecialchars($row["email"]) . "</p>
                                <p><strong>Mobile:</strong> " . htmlspecialchars($row["mobile"]) . "</p>
                                <p><strong>Place:</strong> " . htmlspecialchars($row["places"]) . "</p>
                                <p><strong>Fee:</strong> ₹" . htmlspecialchars($row["fee"]) . "</p>
                                <p><strong>How do you know:</strong> " . htmlspecialchars($row["know_desc"]) . "</p>
                                <a href='mailto:" . htmlspecialchars($row["email"]) . "'>Mail Me</a>
                            </div>
                          </div>";
                }
            } else {
                echo "<p style='color:white;'>No verified users found for that place.</p>";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "<p style='color:white;'>Please enter a place name to search.</p>";
        }
    }
    ?>
  </div>
</div>

<footer>
  &copy; <?php echo date("Y"); ?> KnowEasy | Built with ❤️ by AnuTech Software Solutions
  <marquee scrollamount="4">All rights reserved by AnuTech Software Solutions, established on 23/03/2024 — Contact us for more information.</marquee>
</footer>

</body>
</html>
