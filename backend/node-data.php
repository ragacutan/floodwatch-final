<!-- Test Code -->
<?php
// Replace these values with your actual database credentials
$servername = "srv443.hstgr.io";
$username = "u475920781_flood";
$password = "flood4321A";
$dbname = "u475920781_flood";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate random sensor data
function getRandomSensorData() {
    $sensors = array("sensor_1", "sensor_2", "sensor_3", "sensor_4");
    $randomIndex = array_rand($sensors);
    return $sensors[$randomIndex];
}

$sensorData = getRandomSensorData();

if($sensorData == "sensor_2"){
    $water_level = "2";
}elseif($sensorData == "sensor_3") {
    $water_level = "3";
}elseif($sensorData == "sensor_4"){
    $water_level = "4";
}elseif($sensorData == "sensor_1"){
    $water_level = "1";
}

//Set the default timezone to Manila
date_default_timezone_set('Asia/Manila');
$date2 = date('y-m-d H:i:s'); //24 hours format

$sql = "INSERT INTO waterstatus (`sensor`, `water_level`, `time`) VALUES ('$sensorData', '$water_level', '$date2')";

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
date_default_timezone_set('Asia/Manila');
$date2 = date('d-m-y H:i:s'); //24 hours format
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Refresh Example</title>
    <script>
        // JavaScript function to refresh the page after 5 seconds
        setTimeout(function() {
            location.reload();
        }, 30000); // Refresh every 5 seconds (5000 milliseconds)
    </script>
</head>
<body>
   <p>Check if refresh</p>
   <?php echo $date2; ?>
</body>
</html>