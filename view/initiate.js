// initiate.js - drop this in place of your current file

// ---------- CONFIG ----------
const API_KEY = "d355fe63835b47fe923e362b7e9854eb"; // keep your key here

// ---------- DOM ----------
const modal = document.getElementById("mapModal");
const openMapBtn = document.getElementById("openMapBtn");
const closeBtn = modal.querySelector(".close");
const saveBtn = document.getElementById("saveBtn");

// Inputs we autofill
const addressInput = document.getElementById("addressInput");
const latInput = document.getElementById("latInput");
const lonInput = document.getElementById("lonInput");

// Hidden fields in the main form
const hiddenLat = document.getElementById("latitude");
const hiddenLon = document.getElementById("longitude");
const hiddenAddress = document.getElementById("address");
const locationPreview = document.getElementById("locationPreview");

// Buttons inside modal (select them reliably)
const searchBtn = modal.querySelector(".location-search .location-btn");
const goBtn = modal.querySelector(".coordinate-inputs .location-btn");
const currentLocationBtn = modal.querySelector(".location-actions .location-btn");

// ---------- LEAFLET MAP ----------
let map = null;
let marker = null;
let latestLat = null;
let latestLon = null;
let latestAddress = '';

// Ensure those modal buttons will not submit the form if inside one
[searchBtn, goBtn, currentLocationBtn, saveBtn, openMapBtn].forEach(btn => {
  if (btn) btn.type = "button";
});

// Open / close modal
openMapBtn.addEventListener("click", () => {
  modal.style.display = "block";
  // init map if not already created
  setTimeout(initMap, 100);
});

closeBtn.addEventListener("click", () => modal.style.display = "none");
window.addEventListener("click", (e) => { if (e.target === modal) modal.style.display = "none"; });

// Initialize map (once)
function initMap() {
  if (map) return;
  try {
    map = L.map('map').setView([14.5995, 120.9842], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // click on map -> place marker + autofill reverse geocode
    map.on('click', async e => {
      const lat = e.latlng.lat;
      const lon = e.latlng.lng;
      placeMarker(lat, lon);
      await reverseGeocodeAndFill(lat, lon);
    });

    console.log("Map initialized");
  } catch (err) {
    console.error("Leaflet init error:", err);
    alert("Error initializing map. Check console for details.");
  }
}

function placeMarker(lat, lon) {
  if (!map) return;
  if (marker) marker.setLatLng([lat, lon]);
  else marker = L.marker([lat, lon]).addTo(map);
  map.setView([lat, lon], 14);
}

// Reverse geocode and fill fields
async function reverseGeocodeAndFill(lat, lon) {
  try {
    const url = `https://api.geoapify.com/v1/geocode/reverse?lat=${lat}&lon=${lon}&apiKey=${API_KEY}`;
    const res = await fetch(url);
    const data = await res.json();
    const address = data.features?.[0]?.properties?.formatted || "Address not found";

    // Autofill visible boxes
    addressInput.value = address;
    latInput.value = lat.toFixed(6);
    lonInput.value = lon.toFixed(6);

    // update latest
    latestLat = lat;
    latestLon = lon;
    latestAddress = address;

    if (marker) marker.bindPopup(`<b>${address}</b>`).openPopup();
    console.log("Reverse geocode success:", address);
  } catch (err) {
    console.error("Reverse geocode error:", err);
    alert("Error fetching address from Geoapify. Check console.");
  }
}

// Forward geocode (search by address) and fill
async function searchAddress() {
  const text = addressInput.value?.trim();
  if (!text) return alert("Enter an address first!");
  // ensure map exists
  if (!map) initMap();

  try {
    const url = `https://api.geoapify.com/v1/geocode/search?text=${encodeURIComponent(text)}&apiKey=${API_KEY}`;
    const res = await fetch(url);
    const data = await res.json();
    if (!data.features || data.features.length === 0) return alert("Address not found");

    const feat = data.features[0];
    const lat = feat.geometry.coordinates[1];
    const lon = feat.geometry.coordinates[0];
    const name = feat.properties.formatted;

    placeMarker(lat, lon);

    // Autofill visible fields
    addressInput.value = name;
    latInput.value = lat.toFixed(6);
    lonInput.value = lon.toFixed(6);

    latestLat = lat;
    latestLon = lon;
    latestAddress = name;

    if (marker) marker.bindPopup(`<b>${name}</b>`).openPopup();
    console.log("Search success:", name);
  } catch (err) {
    console.error("Search error:", err);
    alert("Error searching address. Check console.");
  }
}

// Go to coordinates entered manually
async function goToCoordinates() {
  const lat = parseFloat(latInput.value);
  const lon = parseFloat(lonInput.value);
  if (isNaN(lat) || isNaN(lon)) return alert("Invalid coordinates!");

  placeMarker(lat, lon);

  // reverse geocode to get address and fill it
  await reverseGeocodeAndFill(lat, lon);
}

// Get user's current location
function getCurrentLocation() {
  if (!navigator.geolocation) return alert("Geolocation not supported!");
  navigator.geolocation.getCurrentPosition(async pos => {
    const lat = pos.coords.latitude;
    const lon = pos.coords.longitude;
    placeMarker(lat, lon);
    await reverseGeocodeAndFill(lat, lon);
  }, err => {
    console.error("Geolocation error:", err);
    alert("Could not get your location. Check permissions.");
  });
}

// Save (writes to hidden inputs in the form and closes modal)
function saveLocation() {
  if (!latestLat || !latestLon || !latestAddress) return alert("No location selected!");
  hiddenLat.value = latestLat;
  hiddenLon.value = latestLon;
  hiddenAddress.value = latestAddress;
  locationPreview.innerText = `${latestAddress} (${latestLat.toFixed(5)}, ${latestLon.toFixed(5)})`;
  modal.style.display = "none";
}

// ---------- Attach event handlers ----------
if (searchBtn) searchBtn.addEventListener("click", (e) => { e.preventDefault(); searchAddress(); });
if (goBtn) goBtn.addEventListener("click", (e) => { e.preventDefault(); goToCoordinates(); });
if (currentLocationBtn) currentLocationBtn.addEventListener("click", (e) => { e.preventDefault(); getCurrentLocation(); });
if (saveBtn) saveBtn.addEventListener("click", (e) => { e.preventDefault(); saveLocation(); });

// Also support pressing Enter in addressInput to run search (prevent form submit)
addressInput.addEventListener("keydown", (e) => {
  if (e.key === "Enter") { e.preventDefault(); searchAddress(); }
});

// DEBUG: show console hints
console.log("initiate.js loaded - event listeners attached");


  // Show QR file name
  const qrInput = document.getElementById("qrFileInput");
  const qrFileName = document.getElementById("qrFileName");

  qrInput.addEventListener("change", function() {
    if (qrInput.files.length > 0) {
      qrFileName.textContent = qrInput.files[0].name;
    } else {
      qrFileName.textContent = "";
    }
  });

  // Show Attachment file name
  const attachInput = document.getElementById("attachFileInput");
  const attachFileName = document.getElementById("attachFileName");

  attachInput.addEventListener("change", function() {
    if (attachInput.files.length > 0) {
      attachFileName.textContent = attachInput.files[0].name;
    } else {
      attachFileName.textContent = "";
    }
  });




