<?php
session_start();
$account_id = $_SESSION['account_id'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Initiate</title>

  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <link rel="stylesheet" href="initiate.css">
    <link
    href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&family=Jost:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital@0;1&display=swap"
    rel="stylesheet"
  />
</head>

<body>
  <header>
    <a href="#" class="tabFont">ELIZABETH FOUNDATION</a>
    <nav>    
      <a href="gallery.php">HOME</a>
      <a href="fundraisers.php">FUNDRAISERS</a>
      <a href="initiate.php" class="active">INITIATE</a>
      <a href="#">LOG OUT</a>
    </nav>
  </header>

  <div class="container">
    <form action="../controller/initiate.process.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="account_id" value="<?php echo htmlspecialchars($account_id); ?>">
      <input type="hidden" name="latitude" id="latitude">
      <input type="hidden" name="longitude" id="longitude">
      <input type="hidden" name="address" id="address">

      <label for="name">Name of Fundraising</label>
      <input type="text" id="name" name="name" placeholder="Enter Name of Fundraising" required>

      <label for="date">Date of Fundraising</label>
      <input type="date" id="date" name="date" required>

      <!-- <label for="accountNumber">Amount Goal</label>
      <input type="text" id="accountNumber" name="accountNumber" placeholder="Enter Amount Goal" required> -->
      <label for="amount_goal">Amount Goal</label>
      <input type="text" id="amount_goal" name="amount_goal" placeholder="Enter Amount Goal" required>


      <!-- <label for="amount">Account Number</label>
      <input type="tel" id="amount" name="amount" placeholder="+63xxxxxxxxxx" pattern="^\+63\d{10}$" required> -->
      <label for="number">Account Number</label>
      <input type="tel" id="number" name="number" placeholder="+63xxxxxxxxxx" pattern="^\+63\d{10}$" required>

      <label for="description">Description</label>
      <input type="text" id="description" name="description" placeholder="Enter Description" required>

      <!-- 🌍 Select Location -->
      <label for="location">Location</label>
      <button type="button" id="openMapBtn" class="location-btn">Select Location</button>
      <p id="locationPreview" style="color:#555;font-family:'Open Sans',sans-serif;"></p>

      <div id="mapModal" class="modal">
        <div class="modal-content location-modal-content">
          <span class="close">&times;</span>
          <h3>Select Fundraiser Location</h3>

          <div class="location-controls">
            
            <div class="location-search">
              <input type="text" id="addressInput" placeholder="Search address (e.g., Manila)">
              <button class="location-btn" onclick="searchAddress()">Search</button>
            </div>

            <div class="coordinate-inputs">
              <div class="coord-field">
                <label for="latInput">Latitude:</label>
                <input type="text" id="latInput" placeholder="Enter Latitude Here">
              </div>

              <div class="coord-field">
                <label for="lonInput">Longitude:</label>
                <input type="text" id="lonInput" placeholder="Enter Longitude Here">
              </div>

              <button class="location-btn" onclick="goToCoordinates()">Go</button>
            </div>


            <div class="location-actions">
              <button class="location-btn" onclick="getCurrentLocation()">📍 Use Current Location</button>
            </div>
          </div>

          <!-- <p id="output" class="location-output"></p> -->

          <div id="map" class="map-container"></div>

          <button type="button" id="saveBtn" class="save-location-btn">Save Location</button>
        </div>
      </div>


      <!-- 🧾 QR Code -->
      <label id="qrBtn">
        <img src="../img/clip_Img.png" alt="QR Icon"> Add QR Code
        <input type="file" name="qr_image" id="qrFileInput" style="display:none;" accept="image/*">
      </label>
      <span id="qrFileName"></span>

      <!-- 📎 Attachment (image or document) -->
      <label id="attachBtn">
        <img src="../img/clip_Img.png" alt="Attach Icon"> Add Attachment
        <input type="file" name="image" id="attachFileInput" style="display:none;" accept="image/*,.pdf,.doc,.docx">
      </label>
      <span id="attachFileName"></span>


      <div class="div3">
        <button type="submit">Initiate</button>
      </div>
    </form>
  </div>

  <footer>
    <p>&copy; 2024 Elizabeth Foundation. All Rights Reserved.</p>
  </footer>

  <script src="initiate.js"></script>
</body>
</html>
