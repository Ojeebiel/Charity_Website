<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Charity Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="view/index.css">
</head>
<body>
  <div class="left-container">
    <div class="foundation-title">Elizabeth Foundation</div>

    <div class="content-wrapper">
      <h1>Welcome to Our Charity</h1>

        <?php
        // Display login error if redirected with ?error=true
        if (isset($_GET['error']) && $_GET['error'] === 'true') {
            echo '<p style="color: red;">Incorrect email or password. Please try again.</p>';
        }
        ?>

      <form method="POST" action="controller/login.process.php">
        <input type="email" name="email" placeholder="Email Address" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="submit" value="Login" />
      </form>

      <div id="signupdiv">
        <a href="view/signup.php" id="signup">Sign Up</a>
      </div>

      <div class="footer">
        <p>Supporting communities together. <a href="#">Learn more about our work</a>.</p>
      </div>
    </div>
  </div>

  <div class="right-container"></div>
</body>
</html>