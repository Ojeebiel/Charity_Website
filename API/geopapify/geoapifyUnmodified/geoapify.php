<?php require 'geoapify.process.php' ?>

<!DOCTYPE html>
<html>
    <head>
    <title>Geoapify Map Modal + PHP Save</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="geoapify.css" />
    </head>
    <body>
        <h2>Geoapify Map Modal + PHP Save</h2>
        <button id="openMapBtn">Open Map</button>

            <div id="mapModal" class="modal">
                `<div class="modal-content">
                        <span class="close">&times;</span>

                        <div>
                            <input type="text" id="addressInput" placeholder="Type an address (e.g., NYC)" size="50">
                            <button onclick="searchAddress()">Go</button>
                        </div>

                        <div>
                            Latitude: <input type="text" id="latInput" placeholder="e.g. 40.7128">
                            Longitude: <input type="text" id="lonInput" placeholder="e.g. -74.0060">
                            <button onclick="goToCoordinates()">Go</button>
                        </div>
                        
                        <div>
                            <button onclick="getCurrentLocation()">Get Current Location</button>
                        </div>

                            <p id="output"></p>
                            <button id="saveBtn">Save Location</button>
                        <div id="map">
                        
                        </div>`
                </div>
            </div>

        <script src="geoapify.js"></script>
    </body>
</html>