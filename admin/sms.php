<?php
include "../backend/session.php";
include "../backend/functions.php";
include "../backend/check_login.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Perform necessary validations on other form fields if needed

  // Fetch numbers from the database (replace 'your_table' with your actual table name)
  $servername = "srv443.hstgr.io";
  $username = "u475920781_flood";
  $password = "flood4321A";
  $dbname = "u475920781_flood";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT contactNumber FROM users WHERE user_type = 'subscriber'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      // Send the message using cURL for each number
      $ch = curl_init();
      $parameters = array(
        'apikey' => 'a745f6efe0e9c71baa2452bb80075316', // Your API KEY
        'number' => $row['contactNumber'],
        'message' => $_POST["message"],
        'sendername' => 'FLDWATCHTHS'
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
      //echo $output;

      // Close cURL session
      curl_close($ch);
    }
  } else {
    echo "No records found in the database";
  }

  // Close database connection
  $conn->close();
} else {
  echo "Form not submitted.";
}


$servername = "srv443.hstgr.io";
$username = "u475920781_flood";
$password = "flood4321A";
$dbname = "u475920781_flood";

$conn2 = new mysqli($servername, $username, $password, $dbname);

if ($conn2->connect_error) {
  die("Connection failed: " . $conn2->connect_error);
}

$sql2 = "SELECT sensor FROM waterstatus ORDER BY `id` DESC LIMIT 1";
$query2 = $conn2->query($sql2);

$num = mysqli_num_rows($query2);
if ($num > 0) {
  while ($row = mysqli_fetch_array($query2)) {
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




$default_text = "FLOOD WATCH: ($convertedDate, $convertedTime $amPmIndicator) Ang baha ay nakataas na sa $statusCode sa Purok 3, Brgy. Sevilla. $content





Be alert, water may rise without a warning.";



?>


<?php include "layouts/_landing-header.php"; ?>

<body>
  <!-- partial:partials/_navbar.html -->
  <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <a class="navbar-brand brand-logo me-5" href="landing.php" style="display: inline-block;">
        <span>Flood Watch</span>
      </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="ti-view-list"></span>
      </button>
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
            <img src="images/logo.png" alt="profile" />
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
            <a class="dropdown-item">
              <i class="ti-settings text-primary"></i>
              Settings
            </a>
            <a class="dropdown-item" href="../backend/logout.php?logout=true">
              <i class="ti-power-off text-primary"></i>
              Logout
            </a>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
        data-toggle="offcanvas">
        <span class="ti-view-list"></span>
      </button>
    </div>
  </nav>
  <!-- partial -->
  <div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="landing.php">
            <span class="menu-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="sms.php">
            <span class="menu-title">SMS</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="users.php">
            <span class="menu-title">Users</span>
          </a>
        </li>
      </ul>
    </nav>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Messaging</h4>
                    <p class="card-description">
                      Send Messaging Notification
                    </p>
                    <form class="forms-sample" method="POST">
                      <div class="form-group row">
                        <div class="col-sm-9">
                          <textarea id="message" class="form-control" name="message" rows="15"
                            required><?php echo $default_text; ?></textarea>
                        </div>
                      </div>
                      <input type="submit" class="btn btn-primary me-2" value="Send Message">
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- partial -->
    </div>
    <?php include "layouts/_landing-footer.php"; ?>