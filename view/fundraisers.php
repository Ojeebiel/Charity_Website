<?php
session_start();
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

  <style>
    .section-title {
      font-family: 'Josefin Sans', sans-serif;
      font-size: 1.8rem;
      margin: 25px 0 10px;
      text-align: center;
      color: #333;
    }
    .no-fundraiser {
      text-align: center;
      font-family: 'Open Sans', sans-serif;
      font-size: 1.1rem;
      color: #777;
      margin-bottom: 30px;
    }
    /* --- Modal Styles (same as before) --- */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background-color: #fff;
      padding: 25px 35px;
      border-radius: 12px;
      width: 400px;
      text-align: center;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    .modal-content img {
      width: 200px;
      height: 200px;
      border: 1px solid #ccc;
      border-radius: 8px;
      margin: 10px 0;
    }
    .modal-content input {
      width: 90%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-family: 'Open Sans', sans-serif;
    }
    .modal-content button {
      background-color: #0077cc;
      border: none;
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
      margin: 5px;
    }
    .close-btn {
      background-color: #aaa;
    }
  </style>
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
        <div class="project">
          <img class="image" src="../<?php echo $row['image']; ?>" alt="Project Image" />
          <div class="details">
            <div class="project-header">
              <p class="tabFont project-title"><?php echo htmlspecialchars($row['name']); ?></p>
              <p class="project-date"><?php echo htmlspecialchars($row['date']); ?></p>
            </div>
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <button 
              class="contributor-button" 
              data-project="<?php echo htmlspecialchars($row['name']); ?>"
              data-qr="../<?php echo htmlspecialchars($row['image']); ?>"
            >CONTRIBUTOR</button>
            <div class="progress-bar">
              <div class="progress"></div>
              <span class="progress-text">100 / <?php echo $row['amount_goal']; ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>


    <!-- 🔹 OTHER FUNDRAISERS SECTION -->
    <h2 class="section-title">Other Fundraisers</h2>
    <?php foreach ($otherFundraisers as $row): ?>
      <div class="project">
        <img class="image" src="../<?php echo $row['image']; ?>" alt="Project Image" />
        <div class="details">
          <div class="project-header">
            <p class="tabFont project-title"><?php echo htmlspecialchars($row['name']); ?></p>
            <p class="project-date"><?php echo htmlspecialchars($row['date']); ?></p>
          </div>
          <p><?php echo htmlspecialchars($row['description']); ?></p>
          <button 
            class="donate-button" 
            data-project="<?php echo htmlspecialchars($row['name']); ?>"
            data-qr="../<?php echo htmlspecialchars($row['image']); ?>"
          >DONATE</button>
          <div class="progress-bar">
            <div class="progress"></div>
            <span class="progress-text">100 / <?php echo $row['amount_goal']; ?></span>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

  </div>

  <footer>
    <p>&copy; 2024 Elizabeth Foundation. All Rights Reserved.</p>
  </footer>

  <!-- 💰 Donation Modal -->
  <div id="donateModal" class="modal">
    <div class="modal-content">
      <h2>Donate</h2>
      <p>Scan this QR code or fill in the details for <strong id="projectName"></strong></p>
      <img id="qrImage" src="" alt="QR Code">
      <input type="text" id="donorName" placeholder="Your Name" required>
      <input type="number" id="donationAmount" placeholder="Enter amount (₱)" min="1" required>
      <input type="text" id="referenceNumber" placeholder="Reference Number" required>
      <div>
        <button id="confirmDonate">Confirm</button>
        <button class="close-btn" id="closeModal">Cancel</button>
      </div>
    </div>
  </div>

  <!-- 👥 Contributor Modal -->
  <div id="contributorModal" class="modal">
    <div class="modal-content">
      <h2>Contributors</h2>
      <p id="contributorProjectName" style="font-weight: bold;"></p>
      <p>This is a sample list of people who donated to this fundraiser. (You can later fetch real data from the database!)</p>
      <ul id="contributorList" style="text-align: left; margin: 10px 0;">
        <li>✨ John Doe — ₱500.00</li>
        <li>🌸 Maria Santos — ₱1,200.00</li>
        <li>🔥 Alex Cruz — ₱300.00</li>
      </ul>
      <button class="close-btn" id="closeContributor">Close</button>
    </div>
  </div>


  <script>
    const modal = document.getElementById("donateModal");
    const projectNameEl = document.getElementById("projectName");
    const qrImage = document.getElementById("qrImage");
    const closeModalBtn = document.getElementById("closeModal");
    const confirmBtn = document.getElementById("confirmDonate");

    // When a donate button is clicked
    document.querySelectorAll(".donate-button").forEach(button => {
      button.addEventListener("click", () => {
        const project = button.dataset.project;
        const qrSrc = button.dataset.qr;
        projectNameEl.textContent = project;
        qrImage.src = qrSrc;
        modal.style.display = "flex";
      });
    });

    // Close modal
    closeModalBtn.addEventListener("click", () => {
      modal.style.display = "none";
    });

    // Confirm donation
    confirmBtn.addEventListener("click", () => {
      const name = document.getElementById("donorName").value.trim();
      const amount = document.getElementById("donationAmount").value.trim();
      const ref = document.getElementById("referenceNumber").value.trim();
      const project = projectNameEl.textContent;

      if (!name || !amount || !ref) {
        alert("Please fill in all fields before confirming.");
        return;
      }

      alert(`🎉 Thank you, ${name}!\nYou donated ₱${amount} to ${project}.\nRef #: ${ref}`);
      modal.style.display = "none";

      // Reset fields
      document.getElementById("donorName").value = "";
      document.getElementById("donationAmount").value = "";
      document.getElementById("referenceNumber").value = "";
    });

    // Close modal when clicking outside
    window.addEventListener("click", (event) => {
      if (event.target === modal) modal.style.display = "none";
    });



    // Contributor modal elements
    const contributorModal = document.getElementById("contributorModal");
    const closeContributorBtn = document.getElementById("closeContributor");
    const contributorProjectName = document.getElementById("contributorProjectName");

    // Handle Contributor button click
    document.querySelectorAll(".contributor-button").forEach(button => {
      if (button.textContent.trim() === "CONTRIBUTOR") {
        button.addEventListener("click", () => {
          const project = button.dataset.project;
          contributorProjectName.textContent = `Fundraiser: ${project}`;
          contributorModal.style.display = "flex";
        });
      }
    });

    // Close contributor modal
    closeContributorBtn.addEventListener("click", () => {
      contributorModal.style.display = "none";
    });

    // Close if click outside
    window.addEventListener("click", (event) => {
      if (event.target === contributorModal) contributorModal.style.display = "none";
    });

  </script>
</body>
</html>
