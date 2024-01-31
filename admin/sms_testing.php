<?php
$ch = curl_init();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbwater_level";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch numbers and messages from the database (replace 'your_table' with your actual table name)
$sql = "SELECT contactNumber FROM users WHERE user_type = 'user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Use the fetched data in your API request
        $parameters = array(
            'apikey' => 'a745f6efe0e9c71baa2452bb80075316', // Your API KEY
            'number' => $row['contactNumber'],
            'message' => 'Database testing',
            'sendername' => 'SEMAPHORE'
        );

        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute the cURL session and store the result
        $output = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }

        // Show the server response
        echo $output;
    }
} else {
    echo "No records found in the database";
}

// Close database connection
$conn->close();

// Close cURL session
curl_close($ch);
?>
