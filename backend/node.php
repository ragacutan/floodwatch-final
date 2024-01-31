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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sensorData = $_POST["sensor_data"];

    if($sensorData == "sensor_2"){
        $water_level = "2";
    }elseif($sensorData == "sensor_3")
    {
        $water_level = "3";
    }elseif($sensorData == "sensor_4"){
        $water_level = "4";
    }else{
        $water_level = "1";
    }

    $currentTimestamp = time();
    $formattedDate = date('Y-m-d H:i:s', $currentTimestamp);

    $sql = "INSERT INTO waterstatus (`sensor`, `water_level`, `time`) VALUES ('$sensorData', '$water_level', '$formattedDate')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>