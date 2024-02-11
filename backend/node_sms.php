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

// Fetch numbers from the database
$sql = "SELECT contactNumber FROM users WHERE user_type = 'subscriber' AND blasting = 'on' AND sms = 'activated'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Store contact numbers in an array
        $contactNumbers[] = $row['contactNumber'];
    }
} else {
    die("No subscriber records found in the database");
}

// Fetch the latest sensor data
$sql2 = "SELECT sensor FROM waterstatus ORDER BY `id` DESC LIMIT 1";
$query2 = $conn->query($sql2);

$sql3 = "SELECT sensor FROM waterstatus ORDER BY `id` DESC LIMIT 1";
$query3 = $conn->query($sql3);

$num = mysqli_num_rows($query3);
if ($num > 0) {
  while ($row = mysqli_fetch_array($query3)) {
    echo "Water Level: ";
    $waterlevel = $row['sensor'];
    $color = '';

    if ($waterlevel == 'sensor_1') {
      $statusCode = "LOW";
      $content = " ";
    } elseif ($waterlevel == 'sensor_2') {
      $statusCode = "ALERT";
      $content = "Pinapayuhan ang lahat na maging mapagmatyag sa posibleng pag taas ng tubig.";
    } elseif ($waterlevel == 'sensor_3') {
      $statusCode = "ALARM";
      $content ="Maging handa isa posibleng paglikas";
    } elseif ($waterlevel == 'sensor_4') {
      $statusCode = "CRITICAL";
      $content ="Agarang paglikas ay kailangan.";
    } else {
      $statusCode = "WALA";
      $content ="WALA";
    }
  }
}

//Hide this one
date_default_timezone_set('Asia/Manila');

$date = date('d-m-y h:i:s');
$date2 = date('d-m-y H:i:s');

// Convert dmy to month year
$dateTimeObject = DateTime::createFromFormat('d-m-y h:i:s', $date);
$convertedDate = $dateTimeObject->format('F d, Y');

// Convert Time if AM or PM format
$dateTimeObject2 = DateTime::createFromFormat('d-m-y H:i:s', $date2);
$hour = (int)$dateTimeObject2->format('H');

$amPmIndicator = ($hour >= 0 && $hour < 12) ? 'AM' : 'PM';

// Remove seconds and determine if it's AM or PM
$convertedTime = $dateTimeObject->format('h:i');


if ($query2) {
    $row = $query2->fetch_assoc();
    $waterlevel = $row['sensor'];

    // Check if the water level is sensor_4
    if ($waterlevel == 'sensor_4') {
        // Perform the POST request
        foreach ($contactNumbers as $contactNumber) {
            $postData = array(
                'apikey' => 'a745f6efe0e9c71baa2452bb80075316', // Your API KEY
                'number' => $contactNumber,
                'message' => "FLOOD WATCH: ($convertedDate, $convertedTime $amPmIndicator) Ang baha ay nakataas na sa $statusCode sa Purok 3, Brgy. Sevilla. $content

Be alert, water may rise without a warning.",
                'sendername' => 'FLDWATCHTHS'
                // Add other necessary form fields here
            );

            // Initialize cURL session
            $ch = curl_init();

            // Set cURL options
            curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            // Execute cURL session
            $response = curl_exec($ch);

            // Check for errors
            if (curl_errno($ch)) {
                echo 'Curl error: ' . curl_error($ch);
            } else {
                echo "POST request sent successfully to $contactNumber.\n";
            }

            // Close cURL session
            curl_close($ch);
        }
    }elseif ($waterlevel == 'sensor_3') {
            // Perform the POST request
            foreach ($contactNumbers as $contactNumber) {
                $postData = array(
                    'apikey' => 'a745f6efe0e9c71baa2452bb80075316', // Your API KEY
                    'number' => $contactNumber,
                    'message' => "FLOOD WATCH: ($convertedDate, $convertedTime $amPmIndicator) Ang baha ay nakataas na sa $statusCode sa Purok 3, Brgy. Sevilla. $content

Be alert, water may rise without a warning.",
                    'sendername' => 'FLDWATCHTHS'
                    // Add other necessary form fields here
                );
    
                // Initialize cURL session
                $ch = curl_init();
    
                // Set cURL options
                curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
                // Execute cURL session
                $response = curl_exec($ch);
    
                // Check for errors
                if (curl_errno($ch)) {
                    echo 'Curl error: ' . curl_error($ch);
                } else {
                    echo "POST request sent successfully to $contactNumber.\n";
                }
    
                // Close cURL session
                curl_close($ch);
            }

    }elseif ($waterlevel == 'sensor_2') {
            // Perform the POST request
            foreach ($contactNumbers as $contactNumber) {
                $postData = array(
                    'apikey' => 'a745f6efe0e9c71baa2452bb80075316', // Your API KEY
                    'number' => $contactNumber,
                    'message' => "FLOOD WATCH: ($convertedDate, $convertedTime $amPmIndicator) Ang baha ay nakataas na sa $statusCode sa Purok 3, Brgy. Sevilla. $content
                    
Be alert, water may rise without a warning.",
                    'sendername' => 'FLDWATCHTHS'
                    // Add other necessary form fields here
                );
    
                // Initialize cURL session
                $ch = curl_init();
    
                // Set cURL options
                curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
                // Execute cURL session
                $response = curl_exec($ch);
    
                // Check for errors
                if (curl_errno($ch)) {
                    echo 'Curl error: ' . curl_error($ch);
                } else {
                    echo "POST request sent successfully to $contactNumber.\n";
                }
    
                // Close cURL session
                curl_close($ch);
            }

    }else {
        echo "Water level is Normal.";
    }
} else {
    echo "Error fetching sensor data.";
}

// Close database connection
$conn->close();
?>
