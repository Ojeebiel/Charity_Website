// ---------- FILE INPUT DISPLAY ----------
const fileInputs = [
  { input: "qrFileInput", label: "qrFileName" },
  { input: "attachFileInput", label: "attachFileName" }
];

fileInputs.forEach(({ input, label }) => {
  const fileInput = document.getElementById(input);
  const fileNameDisplay = document.getElementById(label);

  fileInput.addEventListener("change", () => {
    fileNameDisplay.textContent = fileInput.files.length > 0
      ? fileInput.files[0].name
      : "";
  });
});

// ---------- GEOAPIFY MAP ----------
const API_KEY = "d355fe63835b47fe923e362b7e9854eb";

const modal = document.getElementById("mapModal");
const btn = document.getElementById("openMapBtn");
const span = document.querySelector(".close");
const saveBtn = document.getElementById("saveBtn");

btn.onclick = function() {
  modal.style.display = "block";
  setTimeout(initMap, 100);
};
span.onclick = function() { modal.style.display = "none"; };
window.onclick = function(e) { if (e.target == modal) modal.style.display = "none"; };

let map, marker;
let latestLat = null, latestLon = null, latestAddress = '';

function initMap() {
  if (map) return;
  map = L.map('map').setView([14.5995, 120.9842], 12);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  map.on('click', async e => {
    const lat = e.latlng.lat, lon = e.latlng.lng;
    if (marker) marker.setLatLng([lat, lon]);
    else marker = L.marker([lat, lon]).addTo(map);

    document.getElementById("output").innerHTML =
      `Latitude: ${lat.toFixed(5)}, Longitude: ${lon.toFixed(5)}<br>Fetching address...`;

    try {
      const res = await fetch(`https://api.geoapify.com/v1/geocode/reverse?lat=${lat}&lon=${lon}&apiKey=${API_KEY}`);
      const data = await res.json();
      const address = data.features[0]?.properties.formatted || "Address not found";
      document.getElementById("output").innerHTML += `<br><b>Address:</b> ${address}`;
      latestLat = lat; latestLon = lon; latestAddress = address;
      marker.bindPopup(`<b>${address}</b>`).openPopup();
    } catch {
      document.getElementById("output").innerHTML += "<br>Error fetching address.";
    }
  });
}

// 🧭 Search Address
async function searchAddress() {
  const address = document.getElementById("addressInput").value;
  if (!address) return alert("Enter an address first!");
  const res = await fetch(`https://api.geoapify.com/v1/geocode/search?text=${encodeURIComponent(address)}&apiKey=${API_KEY}`);
  const data = await res.json();
  if (!data.features.length) return alert("Address not found");

  const lat = data.features[0].geometry.coordinates[1];
  const lon = data.features[0].geometry.coordinates[0];
  const name = data.features[0].properties.formatted;
  map.setView([lat, lon], 14);

  if (marker) marker.setLatLng([lat, lon]);
  else marker = L.marker([lat, lon]).addTo(map);
  marker.bindPopup(`<b>${name}</b>`).openPopup();

  latestLat = lat; latestLon = lon; latestAddress = name;
  document.getElementById("output").innerHTML = `<b>${name}</b><br>${lat}, ${lon}`;
}

// 📍 Go to Coordinates
async function goToCoordinates() {
  const lat = parseFloat(document.getElementById("latInput").value);
  const lon = parseFloat(document.getElementById("lonInput").value);
  if (isNaN(lat) || isNaN(lon)) return alert("Invalid coordinates!");

  const res = await fetch(`https://api.geoapify.com/v1/geocode/reverse?lat=${lat}&lon=${lon}&apiKey=${API_KEY}`);
  const data = await res.json();
  const address = data.features[0]?.properties.formatted || "Address not found";

  map.setView([lat, lon], 14);
  if (marker) marker.setLatLng([lat, lon]); else marker = L.marker([lat, lon]).addTo(map);
  marker.bindPopup(`<b>${address}</b>`).openPopup();

  latestLat = lat; latestLon = lon; latestAddress = address;
  document.getElementById("output").innerHTML = `<b>${address}</b><br>${lat}, ${lon}`;
}

// 🧭 Get Current Location
function getCurrentLocation() {
  if (!navigator.geolocation) return alert("Geolocation not supported!");
  navigator.geolocation.getCurrentPosition(async pos => {
    const lat = pos.coords.latitude, lon = pos.coords.longitude;
    const res = await fetch(`https://api.geoapify.com/v1/geocode/reverse?lat=${lat}&lon=${lon}&apiKey=${API_KEY}`);
    const data = await res.json();
    const address = data.features[0]?.properties.formatted || "Address not found";

    map.setView([lat, lon], 14);
    if (marker) marker.setLatLng([lat, lon]); else marker = L.marker([lat, lon]).addTo(map);
    marker.bindPopup(`<b>${address}</b>`).openPopup();

    latestLat = lat; latestLon = lon; latestAddress = address;
    document.getElementById("output").innerHTML = `<b>${address}</b><br>${lat}, ${lon}`;
  });
}

// 💾 Save Location to Hidden Inputs
saveBtn.addEventListener('click', () => {
  if (!latestLat || !latestLon || !latestAddress) return alert("No location selected!");
  document.getElementById('latitude').value = latestLat;
  document.getElementById('longitude').value = latestLon;
  document.getElementById('address').value = latestAddress;
  document.getElementById('locationPreview').innerText =
    `${latestAddress} (${latestLat.toFixed(5)}, ${latestLon.toFixed(5)})`;
  modal.style.display = "none";
});
