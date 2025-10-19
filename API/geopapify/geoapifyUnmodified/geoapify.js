const API_KEY = "d355fe63835b47fe923e362b7e9854eb";

  // Modal logic
  const modal = document.getElementById("mapModal");
  const btn = document.getElementById("openMapBtn");
  const span = document.querySelector(".close");

  btn.onclick = function() { 
    modal.style.display = "block"; 
    setTimeout(initMap, 100);
  }
  span.onclick = function() { modal.style.display = "none"; }
  window.onclick = function(event) { if (event.target == modal) modal.style.display = "none"; }

  let map;
  let marker; // 🧭 This will hold the map marker
  let latestLat = null;
  let latestLon = null;
  let latestAddress = '';

  function initMap() {
    if (map) return;
    map = L.map('map').setView([40.7128, -74.0060], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // 🟢 When map is clicked:
    map.on('click', async function(e) {
      const lat = e.latlng.lat;
      const lon = e.latlng.lng;

      // If marker already exists, move it — else create it
      if (marker) {
        marker.setLatLng([lat, lon]);
      } else {
        marker = L.marker([lat, lon]).addTo(map);
      }

      document.getElementById("output").innerHTML = 
        `Latitude: ${lat.toFixed(6)}, Longitude: ${lon.toFixed(6)}<br>Fetching address...`;

      try {
        const res = await fetch(`https://api.geoapify.com/v1/geocode/reverse?lat=${lat}&lon=${lon}&apiKey=${API_KEY}`);
        const data = await res.json();
        const address = data.features[0]?.properties.formatted || "Address not found";
        document.getElementById("output").innerHTML += `<br><b>Address:</b> ${address}`;

        latestLat = lat;
        latestLon = lon;
        latestAddress = address;

        // 🧷 Update popup on the marker
        marker.bindPopup(`<b>${address}</b><br>Lat: ${lat.toFixed(5)}, Lon: ${lon.toFixed(5)}`).openPopup();

      } catch (err) {
        console.error(err);
        document.getElementById("output").innerHTML += "<br>Error fetching address.";
      }
    });
  }

  // 🧭 Search by address
  async function searchAddress() {
    const address = document.getElementById("addressInput").value;
    if (!address) return;

    try {
      const res = await fetch(`https://api.geoapify.com/v1/geocode/search?text=${encodeURIComponent(address)}&apiKey=${API_KEY}`);
      const data = await res.json();
      if (!data.features.length) { alert("Address not found"); return; }

      const lat = data.features[0].geometry.coordinates[1];
      const lon = data.features[0].geometry.coordinates[0];
      const displayName = data.features[0].properties.formatted;

      map.setView([lat, lon], 14);

      // 🟢 Move or add marker
      if (marker) marker.setLatLng([lat, lon]);
      else marker = L.marker([lat, lon]).addTo(map);

      marker.bindPopup(`<b>${displayName}</b>`).openPopup();

      latestLat = lat;
      latestLon = lon;
      latestAddress = displayName;

      document.getElementById("output").innerHTML = 
        `<b>Address:</b> ${displayName}<br>Latitude: ${lat}, Longitude: ${lon}`;
    } catch (err) { console.error(err); alert("Error fetching address"); }
  }

  // 🧭 Go to coordinates
  async function goToCoordinates() {
    const lat = parseFloat(document.getElementById("latInput").value);
    const lon = parseFloat(document.getElementById("lonInput").value);
    if (isNaN(lat) || isNaN(lon)) { alert("Invalid coordinates"); return; }

    try {
      const res = await fetch(`https://api.geoapify.com/v1/geocode/reverse?lat=${lat}&lon=${lon}&apiKey=${API_KEY}`);
      const data = await res.json();
      const address = data.features[0]?.properties.formatted || "Address not found";

      map.setView([lat, lon], 14);

      // 🟢 Move or add marker
      if (marker) marker.setLatLng([lat, lon]);
      else marker = L.marker([lat, lon]).addTo(map);

      marker.bindPopup(`<b>${address}</b>`).openPopup();

      latestLat = lat;
      latestLon = lon;
      latestAddress = address;

      document.getElementById("output").innerHTML = 
        `<b>Address:</b> ${address}<br>Latitude: ${lat}, Longitude: ${lon}`;
    } catch (err) { console.error(err); alert("Error fetching address"); }
  }

  // 🧭 Current location
  function getCurrentLocation() {
    if (!navigator.geolocation) { alert("Geolocation not supported"); return; }
    navigator.geolocation.getCurrentPosition(async function(position) {
      const lat = position.coords.latitude;
      const lon = position.coords.longitude;
      try {
        const res = await fetch(`https://api.geoapify.com/v1/geocode/reverse?lat=${lat}&lon=${lon}&apiKey=${API_KEY}`);
        const data = await res.json();
        const address = data.features[0]?.properties.formatted || "Address not found";

        map.setView([lat, lon], 14);

        // 🟢 Move or add marker
        if (marker) marker.setLatLng([lat, lon]);
        else marker = L.marker([lat, lon]).addTo(map);

        marker.bindPopup(`<b>${address}</b>`).openPopup();

        latestLat = lat;
        latestLon = lon;
        latestAddress = address;

        document.getElementById("output").innerHTML = 
          `<b>Current Location:</b> ${address}<br>Latitude: ${lat}, Longitude: ${lon}`;
      } catch (err) { console.error(err); alert("Error fetching address"); }
    }, function() { alert("Unable to retrieve your location"); });
  }

  // 💾 Save to PHP
  document.getElementById('saveBtn').addEventListener('click', function() {
    if (latestLat === null || latestLon === null || !latestAddress) {
      alert("No location selected!");
      return;
    }
    saveLocation(latestLat, latestLon, latestAddress);
  });

  async function saveLocation(lat, lon, address) {
    try {
      const formData = new FormData();
      formData.append('action', 'save');
      formData.append('latitude', lat);
      formData.append('longitude', lon);
      formData.append('address', address);

      const res = await fetch('', { method: 'POST', body: formData });
      const data = await res.json();
      alert(data.message);
    } catch (err) {
      console.error('Failed to save location', err);
    }
  }