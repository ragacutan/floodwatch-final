<?php
require "../backend/db.php";

// Fetch data from the database
$result = $connection->query("SELECT time, sensor, water_level FROM waterstatus");


// Convert data to JSON format
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close the database connection
$connection->close();

// Output JSON data
header('Content-Type: application/json');
echo json_encode($data);
?>
