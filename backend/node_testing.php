<?php
// Connect to the database
$servername = "srv443.hstgr.io";
$username = "u475920781_flood";
$password = "flood4321A";
$dbname = "u475920781_flood";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch numbers from the database
$sql = "SELECT contactNumber FROM users WHERE user_type = 'subscriber'";
$result = $conn->query($sql);

// Loop through the result set and echo each number
while ($row = $result->fetch_assoc()) {
    // Echo the contactNumber
    echo $row['contactNumber'] . "\n";
}

// Close database connection
$conn->close();
?>
