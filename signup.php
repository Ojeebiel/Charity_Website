<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Charity Sign Up</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="signup.css">
</head>
<body>
  <div class="left-container">
    <div class="foundation-title">Elizabeth Foundation</div>

    <div class="content-wrapper">
      <h1>Come Join and Be Among With Us</h1>

      <form method="POST" action="signup.process.php">
        <input type="text" placeholder="Username" name="username" required />
        <input type="password" placeholder="Password" name="password" required />
        <input type="text" placeholder="First Name" name="fName" required />
        <input type="text" placeholder="Last Name" name="lName" required />
        <input type="submit" value="Sign Up" />
      </form>

      <div class="footer">
        <p>
          Supporting communities together.
          <a href="#">Learn more about our work</a>.
        </p>
      </div>
    </div>

  </div>

<div class="right-container">
  <img src="img/background1.jpg" alt="Foundation Background">
</div>
</body>
</html>
