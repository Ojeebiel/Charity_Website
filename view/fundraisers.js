// ---------- PROGRESS BAR ----------
document.querySelectorAll(".progress-bar").forEach(bar => {
  const text = bar.querySelector(".progress-text").textContent.trim();
  const [current, goal] = text.split("/").map(v => parseFloat(v.replace(/,/g, "")));

  if (!isNaN(current) && !isNaN(goal) && goal > 0) {
    const percentage = Math.min((current / goal) * 100, 100);
    bar.querySelector(".progress").style.width = percentage + "%";
  }
});

// ---------- DONATION MODAL ----------
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
    const fundraiserId = button.dataset.id;
    const accountId = button.dataset.account;
    const recipientId = button.dataset.recipient;
    const number = button.dataset.number;

    projectNameEl.textContent = project;
    qrImage.src = qrSrc;

    const numberEl = document.getElementById("fundraiserNumber");
    numberEl.textContent = number ? `📱 Contact Number: ${number}` : "No contact number provided.";


    document.getElementById("fundraiserId").value = fundraiserId;
    document.querySelector('input[name="account_id"]').value = accountId;
    document.querySelector('input[name="recipient_id"]').value = recipientId;

    console.log("✅ Fundraiser ID:", fundraiserId);
    console.log("✅ Account ID:", accountId);
    console.log("✅ Recipient ID:", recipientId);

    modal.style.display = "flex";
  });
});



// Close modal
closeModalBtn.addEventListener("click", () => {
  modal.style.display = "none";
});

// Confirm donation
confirmBtn.addEventListener("click", (event) => {
  event.preventDefault(); // stop accidental reload

  const amount = document.getElementById("donationAmount").value.trim();
  const ref = document.getElementById("referenceNumber").value.trim();
  const project = projectNameEl.textContent;
  const fundraiserId = document.getElementById("fundraiserId").value;

  if (!amount || !ref) {
    alert("Please fill in all fields before confirming.");
    return;
  }

  console.log(`🎉 Donation submitted:
  Fundraiser ID: ${fundraiserId}
  Amount: ₱${amount}
  Ref #: ${ref}`);

  // ✅ Actually submit the form now
  document.getElementById("donationForm").submit();

  // Optional visual cleanup after submit
  modal.style.display = "none";
});



// Close modal when clicking outside
window.addEventListener("click", (event) => {
  if (event.target === modal) modal.style.display = "none";
});

// ---------- CONTRIBUTOR MODAL ----------
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
