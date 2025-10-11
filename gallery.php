<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gallery</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&family=Jost:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital@0;1&display=swap"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="gallery.css" />
</head>
<body>
  <header>
    <div class="tabFont"><a href="#">ELIZABETH FOUNDATION</a></div>

    <?php
    session_start();
    $current_page = basename($_SERVER['PHP_SELF']);
    ?>
    <nav>
      <a href="gallery.php">HOME</a>
      <a href="fundraisers.php">FUNDRAISERS</a>
      <a href="initiate.php">INITIATE</a>
      <a href="#">LOG OUT</a>
    </nav>
  </header>

  <!-- GALLERY ENTRY 1 -->
  <div class="div1">
    <div class="container">
      <div class="item text text-1">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin id massa eu dui
        bibendum euismod. Nullam finibus elementum odio.
      </div>
      <div class="item text text-2">October 10, 2025</div>

      <div class="item item-1">
        <img class="image" src="img/image1.jpg" alt="Gallery Image 1" />
      </div>
      <div class="item item-2">
        <img class="image" src="img/image2.jpg" alt="Gallery Image 2" />
      </div>
      <div class="item item-3">
        <img class="image" src="img/image6.jpg" alt="Gallery Image 3" />
      </div>
      <div class="item item-4">
        <img class="image" src="img/image4.jpg" alt="Gallery Image 4" />
      </div>
      <div class="item item-5">
        <img class="image" src="img/image5.jpg" alt="Gallery Image 5" />
      </div>
    </div>
  </div>



  <footer>
    <p>&copy; 2025 Elizabeth Foundation. All Rights Reserved.</p>
  </footer>
</body>
</html>
