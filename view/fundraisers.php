<?php
session_start();
// Get the data from session
$rows = $_SESSION['fundraisers'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&family=Open+Sans:ital@0;1&display=swap"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="fundraisers.css">
  <title>Fundraisers</title>

</head>
<body>
  <header>
    <a href="#" class="tabFont">ELIZABETH FOUNDATION</a>
    <nav>
      <a href="gallery.php">HOME</a>
      <a href="fundraisers.php">FUNDRAISERS</a>
      <a href="initiate.php">INITIATE</a>
      <a href="#">LOG OUT</a>
    </nav>
  </header>

<div class="container">
  <?php echo "Count: " . count($rows); ?>

  <?php foreach ($rows as $row) { ?>
    <div class="project">
      
      <img class="image" src="../<?php echo $row['image']; ?>" alt="Project Image 1" />
      <div class="details">
        
        <div class="project-header">
          <p class="tabFont project-title"><?php echo $row['name']; ?></p>
          <p class="project-date"><?php echo $row['date']; ?></p>
        </div>
        <p><?php echo $row['description']; ?></p>
        <button class="donate-button">DONATE</button>
        <div class="progress-bar">
          <div class="progress"></div>
          <span class="progress-text"> 100 / <?php echo $row['amount_goal']; ?></span>
        </div>
      </div>
    </div>
  <?php } ?>

  
</div>


  <footer>
    <p>&copy; 2024 Elizabeth Foundation. All Rights Reserved.</p>
  </footer>
  <script src="fundraiser.js"></script>
</body>
</html>

