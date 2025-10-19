  document.querySelectorAll(".progress-bar").forEach(bar => {
    const text = bar.querySelector(".progress-text").textContent.trim();
    const [current, goal] = text.split("/").map(v => parseFloat(v.replace(/,/g, "")));
    
    if (!isNaN(current) && !isNaN(goal) && goal > 0) {
      const percentage = Math.min((current / goal) * 100, 100); // cap at 100%
      bar.querySelector(".progress").style.width = percentage + "%";
    }
  });


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