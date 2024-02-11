<?php
include "../backend/session.php";
include "../backend/functions.php";
include "../backend/check_login.php";

date_default_timezone_set('Asia/Taipei');
$apiKey = "10f78797831bb67ce3a30494eeff3534";
$cityId = "1707052";
$googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $cityId . "&lang=en&units=metric&APPID=" . $apiKey;

$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);

curl_close($ch);
$data = json_decode($response);
$currentTime = time();

$select = "SELECT `time`, `sensor`  FROM `waterstatus` ORDER BY `id` DESC LIMIT 7";
$query = mysqli_query($connection, $select);
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
          <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h4 class="font-weight-bold mb-0">Welcome!
                  <?= $_SESSION['name'] ?>
                </h4>
              </div>
              <div>
                <a href="signup.php" class="btn btn-primary btn-icon-text btn-rounded" class="btn btn-default">Create Admin</a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <p class="card-title text-md-center text-xl-left">Registered Subscriber</p>
                <div
                  class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                  <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">

                    <?php
                    $select = "SELECT * FROM users WHERE user_type = 'subscriber'";
                    $query_run = mysqli_query($connection, $select);

                    $row = mysqli_num_rows($query_run);
                    echo '<h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">' . $row . '</h3>';
                    ?>
                  </h3>
                  <i class="ti-user icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <p class="card-title text-md-center text-xl-left">Activated Subsriber</p>
                <div
                  class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                  <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">

                    <?php
                    $select = "SELECT * FROM users WHERE user_type = 'subscriber' AND sms = 'activated'";
                    $query_run = mysqli_query($connection, $select);

                    $row = mysqli_num_rows($query_run);
                    echo '<h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">' . $row . '</h3>';
                    ?>
                  </h3>
                  <i class="ti-user icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <p class="card-title text-md-center text-xl-left">Registered Admin</p>
                <div
                  class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                  <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">

                    <?php
                    $select = "SELECT * FROM users WHERE user_type = 'admin'";
                    $query_run = mysqli_query($connection, $select);

                    $row = mysqli_num_rows($query_run);
                    echo '<h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">' . $row . '</h3>';
                    ?>
                  </h3>
                  <i class="ti-user icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <p class="card-title mb-0">Water Level Status (The Uppermost Data is the Latest)</p>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Time</th>
                        <th>Water Level</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $num = mysqli_num_rows($query);
                      if ($num > 0) {
                        while ($row = mysqli_fetch_array($query)) {
                          echo '<tr>';
                          echo '<td>' . date("F d, Y @ g:i a", strtotime($row['time'])) . '</td>';
                          echo '<td>' . $row['sensor'] . '</td>';
                          $waterlevel = $row['sensor'];
                          $color = '';

                          if ($waterlevel == 'sensor_1') {
                            $color = 'green';
                            $status = 'low';
                          } elseif ($waterlevel == 'sensor_2') {
                            $color = 'yellow';
                            $status = 'Alert';
                          } elseif ($waterlevel == 'sensor_3') {
                            $color = 'orange';
                            $status = 'Alarm';
                          } elseif ($waterlevel == 'sensor_4') {
                            $color = 'red';
                            $status = 'Critical';
                          } else {
                            $color = 'gray';
                            $status = '';
                          }

                          echo '<td style="background-color: ' . $color . '; color: black; font-weight: bold; text-align: center;">' . $status . '</td>';
                          echo '<tr>';
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Weather Status</h4>
                <div class="pt-2">
                  <tbody>
                    <tr>
                      <td><span style="color: black;">Date:</span>
                        <?php echo date("F j, Y", $currentTime) . ' || ' . date("l", $currentTime); ?>
                      </td>
                    </tr>
                    <br>
                    <br>
                    <br>
                    <tr>
                      <td><span style="color: black;">Time: <span id="demo"></span></span></td>
                    </tr>
                    <br>
                    <br>
                    <br>
                    <tr>
                      <td><span style="color: black;">Weather Forecast: </span>
                        <?php echo ucwords($data->weather[0]->description); ?> <span><img
                            src="http://openweathermap.org/img/w/<?php echo $data->weather[0]->icon; ?>.png"
                            class="weather-icon" </span>
                      </td>
                    </tr>
                    <br>
                    <br>
                    <br>
                    <tr>
                      <td><span style="color: darkblue;">Temperature:</span>
                        <?php echo $data->main->temp_max; ?>&deg;
                      </td>
                    </tr>
                    <br>
                    <br>
                    <br>
                    <tr>
                      <td><span style="color: darkred;">Humidity:</span>
                        <?php echo $data->main->humidity; ?> %
                      </td>
                    </tr>
                    <br>
                    <br>
                    <br>
                    <tr>
                      <td><span style="color: darkgreen;">Wind:</span>
                        <?php echo $data->wind->speed; ?> Km/H
                      </td>
                    </tr>
                    <br>
                    <br>
                    <br>
                  </tbody>
                </div>
              </div>
            </div>
          </div>
          <div class="content-wrapper">
            <div class="row">
              <div style="width: 100%; height: 600px;">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Average Water Level Graph Per Minute</h4>
                    <canvas style="width: 100%; height: 400px;" id="myChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="content-wrapper">
            <div class="row">
              <div style="width: 100%; height: 600px;">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Average Water Level Graph Per Hour </h4>
                    <canvas style="width: 100%; height: 400px;" id="myChart2"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="content-wrapper">
            <div class="row">
              <div style="width: 100%; height: 600px;">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Average Water Level Graph Per Day </h4>
                    <canvas style="width: 100%; height: 400px;" id="myChart3"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- partial -->
    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>

  <script>
  fetch('getData.php')
    .then(response => response.json())
    .then(data => {
      // Process the fetched data and create the Chart.js chart
      var ctx = document.getElementById('myChart').getContext('2d');

      // Function to calculate average time per minute
      function calculateAverageTime(data) {
        var averages = [];
        var sum = 0;
        var count = 0;
        var minuteStart = new Date(data[0].time).getMinutes(); // Get the minute of the first data point
        for (var i = 0; i < data.length; i++) {
          sum += new Date(data[i].time).getTime(); // Convert time to milliseconds
          count++;
          // Check if a minute has passed or if it's the last data point
          if (i === data.length - 1 || new Date(data[i + 1].time).getMinutes() !== minuteStart) {
            averages.push(new Date(sum / count)); // Calculate average and push to averages array
            sum = 0;
            count = 0;
            if (i !== data.length - 1) {
              minuteStart = new Date(data[i + 1].time).getMinutes(); // Update minuteStart for the next minute
            }
          }
        }
        return averages;
      }

      // Calculate average time per minute
      var averageTimes = calculateAverageTime(data);

      // Create labels for the chart
      var labels = averageTimes.map(date => date.toLocaleString());

      var chartData = {
        labels: labels,
        datasets: [{
          label: 'Water Level',
          data: data.map(item => item.water_level),
          fill: false,
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 2,
          pointRadius: 5,
          pointBackgroundColor: 'rgba(75, 192, 192, 1)',
          pointBorderColor: 'rgba(75, 192, 192, 1)',
          pointHoverRadius: 8,
          pointHoverBackgroundColor: 'rgba(75, 192, 192, 1)',
          pointHoverBorderColor: 'rgba(75, 192, 192, 1)',
          yAxisID: 'y-axis-0', // Add this line to specify the y-axis for this dataset
        }]
      };

      var options = {
        scales: {
          y: {
            beginAtZero: true,
            suggestedMin: 0,
            suggestedMax: 5
          }
        }
      };

      var myChart = new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: options
      });
    })
    .catch(error => console.error('Error fetching data:', error));
</script>

<script>
  fetch('getData.php')
    .then(response => response.json())
    .then(data => {
      // Process the fetched data and create the Chart.js chart
      var ctx = document.getElementById('myChart2').getContext('2d');

      // Function to calculate average time per hour
      function calculateAverageTime(data) {
        var averages = [];
        var sum = 0;
        var count = 0;
        var hourStart = new Date(data[0].time).getHours(); // Get the hour of the first data point
        for (var i = 0; i < data.length; i++) {
          sum += new Date(data[i].time).getTime(); // Convert time to milliseconds
          count++;
          // Check if an hour has passed or if it's the last data point
          if (i === data.length - 1 || new Date(data[i + 1].time).getHours() !== hourStart) {
            averages.push(new Date(sum / count)); // Calculate average and push to averages array
            sum = 0;
            count = 0;
            if (i !== data.length - 1) {
              hourStart = new Date(data[i + 1].time).getHours(); // Update hourStart for the next hour
            }
          }
        }
        return averages;
      }

      // Calculate average time per hour
      var averageTimes = calculateAverageTime(data);

      // Create labels for the chart
      var labels = averageTimes.map(date => date.toLocaleString());

      var chartData = {
        labels: labels,
        datasets: [{
          label: 'Water Level',
          data: data.map(item => item.water_level),
          fill: false,
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 2,
          pointRadius: 5,
          pointBackgroundColor: 'rgba(75, 192, 192, 1)',
          pointBorderColor: 'rgba(75, 192, 192, 1)',
          pointHoverRadius: 8,
          pointHoverBackgroundColor: 'rgba(75, 192, 192, 1)',
          pointHoverBorderColor: 'rgba(75, 192, 192, 1)',
          yAxisID: 'y-axis-0', // Add this line to specify the y-axis for this dataset
        }]
      };

      var options = {
        scales: {
          y: {
            beginAtZero: true,
            suggestedMin: 0,
            suggestedMax: 5
          }
        }
      };

      var myChart = new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: options
      });
    })
    .catch(error => console.error('Error fetching data:', error));
</script>

<script>
    fetch('getData.php')
      .then(response => response.json())
      .then(data => {
        // Process the fetched data and create the Chart.js chart
        var ctx = document.getElementById('myChart3').getContext('2d');

        // Function to calculate average time per day
        function calculateAverageTime(data) {
          var averages = [];
          var sum = 0;
          var count = 0;
          var dayStart = new Date(data[0].time).getDate(); // Get the day of the first data point
          for (var i = 0; i < data.length; i++) {
            sum += new Date(data[i].time).getTime(); // Convert time to milliseconds
            count++;
            // Check if a day has passed or if it's the last data point
            if (i === data.length - 1 || new Date(data[i + 1].time).getDate() !== dayStart) {
              averages.push(new Date(sum / count)); // Calculate average and push to averages array
              sum = 0;
              count = 0;
              if (i !== data.length - 1) {
                dayStart = new Date(data[i + 1].time).getDate(); // Update dayStart for the next day
              }
            }
          }
          return averages;
        }

        // Calculate average time per day
        var averageTimes = calculateAverageTime(data);

        // Create labels for the chart
        var labels = averageTimes.map(date => date.toLocaleString());

        var chartData = {
          labels: labels,
          datasets: [{
            label: 'Water Level',
            data: data.map(item => item.water_level),
            fill: false,
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
            pointRadius: 5,
            pointBackgroundColor: 'rgba(75, 192, 192, 1)',
            pointBorderColor: 'rgba(75, 192, 192, 1)',
            pointHoverRadius: 8,
            pointHoverBackgroundColor: 'rgba(75, 192, 192, 1)',
            pointHoverBorderColor: 'rgba(75, 192, 192, 1)',
            yAxisID: 'y-axis-0', // Add this line to specify the y-axis for this dataset
          }]
        };

        var options = {
          scales: {
            y: {
              beginAtZero: true,
              suggestedMin: 0,
              suggestedMax: 5
            }
          }
        };

        var myChart = new Chart(ctx, {
          type: 'line',
          data: chartData,
          options: options
        });
      })
      .catch(error => console.error('Error fetching data:', error));
</script>





  <?php include "layouts/_landing-footer.php"; ?>