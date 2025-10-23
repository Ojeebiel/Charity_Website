<?php
session_start();
$account_id = $_SESSION['account_id'];


require '../controller/fundraisers.process.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&family=Open+Sans:ital@0;1&display=swap" rel="stylesheet" />
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

    <!-- 🔹 YOUR FUNDRAISERS SECTION -->
    <h2 class="section-title">My Fundraisers</h2>

    <?php if (count($myFundraisers) === 0): ?>
      <p class="no-fundraiser">You haven’t added any fundraisers yet. <a href="initiate.php">Add a fundraiser now!</a></p>
    <?php else: ?>
      <?php foreach ($myFundraisers as $row): ?>
        <div class="project my-fundraiser-layout">
          
          <!-- LEFT SIDE: Fundraiser details -->
          <div class="fundraiser-left">
            <img class="image" src="<?php echo $row['image']; ?>" alt="Project Image" />
            <div class="details">
              <div class="project-header">
                <p class="tabFont project-title"><?php echo htmlspecialchars($row['name']); ?></p>
                <p class="project-date"><?php echo htmlspecialchars($row['date']); ?></p>
              </div>
              <p><?php echo htmlspecialchars($row['description']); ?></p>
              <p><?php echo htmlspecialchars($row['address']); ?></p>

              <button 
                class="view-map-button"
                data-lat="<?php echo htmlspecialchars($row['latitude']); ?>"
                data-lon="<?php echo htmlspecialchars($row['longitude']); ?>"
                data-address="<?php echo htmlspecialchars($row['address']); ?>"
              >
                View on Map
              </button>

              <div class="progress-bar">
                <div class="progress"></div>
                <span class="progress-text"><?php echo $row['amount_donated']; ?> / <?php echo $row['amount_goal']; ?></span>
              </div>
            </div>
          </div>

          <!-- RIGHT SIDE: Contributors -->
          <div class="fundraiser-right">
            <h3>Contributors</h3>

            <?php 
              // ✅ Fetch contributors from DB
              $sql =  "SELECT 
                          d.donation_id, 
                          a.name, 
                          d.amount, 
                          d.ref_number
                      FROM 
                          donation d
                      JOIN 
                          accounts a ON d.account_id = a.account_id
                      WHERE 
                          d.recipient_id = ? 
                          AND d.status = 0
                          AND d.fundraiser_id = ?";

              $stmt = $conn->prepare($sql);
              $stmt->bind_param("ii", $account_id, $row['fundraiser_id']);
              $stmt->execute();
              $result = $stmt->get_result();

              // Store contributors in an array
              $contributors = [];
              while ($donor = $result->fetch_assoc()) {
                $contributors[] = $donor;
              }
            ?>

            




            <?php if (!empty($contributors)): ?>
              <ul class="contributor-list">
                <?php foreach ($contributors as $donor): ?>
                  <li class="contributor-item">
                    <div class="donor-info">
                      <strong><?php echo htmlspecialchars($donor['name']); ?></strong><br>
                      ₱<?php echo number_format($donor['amount'], 2); ?><br>
                      <small>Ref: <?php echo htmlspecialchars($donor['ref_number']); ?></small>
                    </div>

                    <div class="donor-actions">
                      <form action="../controller/funraisers.process.donation.php" method="POST" style="display:inline;">
                        <input type="hidden" name="donation_id" value="<?php echo (int)$donor['donation_id']; ?>">
                        <input type="hidden" name="status" value="1">
                        <button type="submit" class="confirm-btn">Confirm</button>
                      </form>

                      <form action="../controller/funraisers.process.donation.php" method="POST" style="display:inline;">
                        <input type="hidden" name="donation_id" value="<?php echo (int)$donor['donation_id']; ?>">
                        <input type="hidden" name="status" value="2">
                        <button type="submit" class="invalid-btn">Invalid</button>
                      </form>
                    </div>


                  </li>
                <?php endforeach; ?>
              </ul>
            <?php else: ?>
              <p class="no-contributors">No contributions yet.</p>
            <?php endif; ?>
          </div>




        </div>
      <?php endforeach; ?>
    <?php endif; ?>



    <!-- 🔹 OTHER FUNDRAISERS SECTION -->
    <h2 class="section-title">Other Fundraisers</h2>
    <?php foreach ($otherFundraisers as $row): ?>
      <div class="project">
        <img class="image" src="<?php echo $row['image']; ?>" alt="Project Image" />
        <div class="details">
          <div class="project-header">
            <p class="tabFont project-title"><?php echo htmlspecialchars($row['name']); ?></p>
            <p class="project-date"><?php echo htmlspecialchars($row['date']); ?></p>
          </div>
          <p><?php echo htmlspecialchars($row['description']); ?></p>


          <!--added code 10-21-25 12:11pm-->
          <?php echo htmlspecialchars($row['address']); ?>
          <button 
              class="view-map-button"
              data-lat="<?php echo htmlspecialchars($row['latitude']); ?>"
              data-lon="<?php echo htmlspecialchars($row['longitude']); ?>"
              data-address="<?php echo htmlspecialchars($row['address']); ?>"
            >
              View on Map
          </button>

      
          <button 
            class="donate-button" 
            data-project="<?php echo htmlspecialchars($row['name']); ?>"
            data-qr="<?php echo htmlspecialchars($row['image']); ?>"
            data-id="<?= htmlspecialchars($row['fundraiser_id']); ?>"
            data-account="<?= htmlspecialchars($account_id); ?>"
            data-recipient="<?= htmlspecialchars($row['account_id']); ?>"
          >
            DONATE
          </button>


          <div class="progress-bar">
            <div class="progress"></div>
            <span class="progress-text"><?php echo $row['amount_donated']; ?> / <?php echo $row['amount_goal']; ?></span>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

  </div>

  <footer>
    <p>&copy; 2024 Elizabeth Foundation. All Rights Reserved.</p>
  </footer>

  <!-- Donation Modal -->
  <div id="donateModal" class="modal">
    <div class="modal-content">
      <h2>Donate</h2>
      <p>Scan this QR code or fill in the details for <strong id="projectName"></strong></p>
      <img id="qrImage" src="" alt="QR Code">
      <!-- <input type="text" id="donorName" placeholder="Your Name" required> -->
       
      <form id="donationForm" method="POST" action="../controller/fundraisers.process.php">
        <input type="hidden" id="fundraiserId" name="fundraiser_id" value="">
        <input type="hidden" id="accountId" name="account_id" value="">
        <input type="hidden" id="recipientId" name="recipient_id" value="">


        <input type="number" id="donationAmount" name="amount" placeholder="Enter amount (₱)" min="1" required>
        <input type="text" id="referenceNumber" name="ref_number" placeholder="Reference Number" required>

        <div>
          <button type="submit" id="confirmDonate">Confirm</button>
          <button type="button" class="close-btn" id="closeModal">Cancel</button>
        </div>
      </form>

    </div>
  </div>

  <!-- Contributor Modal -->
  <div id="contributorModal" class="modal">
    <div class="modal-content">
      <h2>Contributors</h2>
      <p id="contributorProjectName" style="font-weight: bold;"></p>
      <p>This is a sample list of people who donated to this fundraiser. (You can later fetch real data from the database!)</p>
      <ul id="contributorList" style="text-align: left; margin: 10px 0;">
        <li>John Doe — ₱500.00</li>
        <li>Maria Santos — ₱1,200.00</li>
        <li>Alex Cruz — ₱300.00</li>
      </ul>
      <button class="close-btn" id="closeContributor">Close</button>
    </div>
  </div>

  <!-- 🌍 Map Modal -->
          <div id="mapViewModal" class="modal">
            <div class="modal-content location-modal-content">
              <span class="close" id="closeMapView">&times;</span>
              <h3 id="mapAddressTitle">Fundraiser Location</h3>
              <div id="mapView" style="height: 400px; border-radius: 10px; margin-top: 10px;"></div>
            </div>
          </div>
          
  <script src="fundraisers.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <script>
  /*
    ✅ Fixed "View on Map" Modal Script
    - Shows only one map
    - Reuses the same Leaflet instance each time
    - No more broken or duplicated maps
  */

  document.addEventListener("DOMContentLoaded", () => {
    const mapModal = document.getElementById("mapViewModal");
    const closeMapView = document.getElementById("closeMapView");
    const mapAddressTitle = document.getElementById("mapAddressTitle");
    let mapInstance = null;
    let markerInstance = null;

    // Open modal function
    function openModal() {
      mapModal.style.display = "flex";
    }

    // Close modal function
    function closeModal() {
      mapModal.style.display = "none";
    }

    // Initialize map only once
    function initMap(lat, lon) {
      if (!mapInstance) {
        mapInstance = L.map("mapView", { scrollWheelZoom: true }).setView([lat, lon], 15);

        // Add tile layer once
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
          attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
        }).addTo(mapInstance);
      } else {
        // Update view if map already exists
        mapInstance.setView([lat, lon], 15);
      }

      // Add or move marker
      if (markerInstance) {
        markerInstance.setLatLng([lat, lon]);
      } else {
        markerInstance = L.marker([lat, lon]).addTo(mapInstance);
      }

      // Wait a bit to fix map rendering
      setTimeout(() => mapInstance.invalidateSize(), 300);
    }

    // Handle all "View on Map" buttons
    document.querySelectorAll(".view-map-button").forEach(button => {
      button.addEventListener("click", () => {
        const lat = parseFloat(button.dataset.lat);
        const lon = parseFloat(button.dataset.lon);
        const address = button.dataset.address || "Unknown location";

        if (isNaN(lat) || isNaN(lon)) {
          alert("⚠️ Location data missing for this fundraiser.");
          return;
        }

        // Set modal title
        mapAddressTitle.textContent = address;

        // Open modal and show map
        openModal();
        initMap(lat, lon);

        // Add popup to marker
        if (markerInstance) {
          markerInstance.bindPopup(`<b>${address}</b>`).openPopup();
        }
      });
    });

    // Close modal when clicking X or outside
    closeMapView.addEventListener("click", closeModal);
    window.addEventListener("click", (e) => {
      if (e.target === mapModal) closeModal();
    });
  });
  </script>




</body>
</html>
