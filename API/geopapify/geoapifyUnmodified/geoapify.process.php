<?php
  // ----- PHP Backend for saving coordinates -----
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save') {
      header('Content-Type: application/json');

      $host = "localhost";
      $user = "root"; // your DB username
      $pass = "";     // your DB password
      $dbname = "test"; // your database

      $conn = new mysqli($host, $user, $pass, $dbname);
      if ($conn->connect_error) {
          echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
          exit;
      }

      $lat = $_POST['latitude'] ?? null;
      $lon = $_POST['longitude'] ?? null;
      $address = $_POST['address'] ?? null;

      if ($lat === null || $lon === null || !$address) {
          echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
          exit;
      }

      $stmt = $conn->prepare("INSERT INTO locations (latitude, longitude, address) VALUES (?, ?, ?)");
      $stmt->bind_param("dds", $lat, $lon, $address);
      if ($stmt->execute()) {
          echo json_encode(['status' => 'success', 'message' => 'Coordinates saved']);
      } else {
          echo json_encode(['status' => 'error', 'message' => 'Failed to save']);
      }

      $stmt->close();
      $conn->close();
      exit;
  }
?>