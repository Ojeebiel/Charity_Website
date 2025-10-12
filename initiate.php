<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&family=Open+Sans:ital@0;1&display=swap" rel="stylesheet">

  <title>Initiate</title>
  <link rel="stylesheet" href="initiate.css">
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
    <form action="initiate.process.php">
      <label for="name">Name of Fundraising</label>
      <input type="text" placeholder="Enter Name of Fundraising" id="name" required>

      <label for="date">Date of Fundraising</label>
      <input type="text" placeholder="Enter Date of Fundraising" id="date" required>

      <label for="amount">Amount Goal</label>
      <input type="text" placeholder="Enter Amount Goal" id="amount" required>

      <label for="description">Description</label>
      <input type="text" placeholder="Enter Description" id="description" required>

      <label for="location">Location</label>
      <div id="locationBtn"><img src="img/map_icon.png" alt="Map Icon">Select Location</div>

      <div id="locationModal" class="modal">
        <div class="modal-content">
          <span class="close-location">&times;</span>
          <h3>Select Fundraiser Location</h3>
          <div class="map-placeholder">
            <p>🗺️ Map Placeholder Area</p>
          </div>
        </div>
      </div>

    <label id="myBtn">
      <img src="img/clip_Img.png" alt="Icon">
      Add Attachments
      <input type="file" name="image" id="fileInput" accept="image/*">
    </label>

    <!-- This span will show the file name -->
    <span id="fileName" style="margin-left: 10px; font-family: 'Open Sans', sans-serif; color: #555;"></span>



      <div id="myModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <input class="form-control" type="file" name="uploadfile" required>
        </div>
      </div>

      <div class="div3">
        <button type="submit">Initiate</button>
      </div>
    </form>

  </div>

  <footer>
    <p>&copy; 2024 Elizabeth Foundation. All Rights Reserved.</p>
  </footer>
</body>
</html>
