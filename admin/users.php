<?php
require '../backend/db.php';
include "../backend/session.php";
include "../backend/functions.php";
include "../backend/check_login.php";

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  // Sanitize the input to prevent SQL injection
  $id = mysqli_real_escape_string($connection, $id);

  $select3 = "SELECT * FROM users WHERE `id` = '$id'";
  $query3 = mysqli_query($connection, $select3);

  if ($query3) {
      $result = mysqli_fetch_assoc($query3);

      if ($result) {
          $sms = $result['sms'];
          $newStatus = '';

          if ($sms == "activated") {
              $newStatus = "deactivated";
          } elseif ($sms == "deactivated") {
              $newStatus = "activated";
          }

          // Update the status in the database
          $updateQuery = "UPDATE users SET `sms` = '$newStatus' WHERE `id` = '$id'";
          $query4 = mysqli_query($connection, $updateQuery);

          if ($query4) {
              // Redirect after successful update
              header('Location: users.php');
              exit(); // Make sure to exit after redirecting
          } else {
              echo "Error updating status: " . mysqli_error($connection);
          }
      } else {
          echo "No SMS found for the provided ID.";
      }
  } else {
      echo "Error executing the query: " . mysqli_error($connection);
  }
}

$select = "SELECT * FROM users WHERE user_type = 'subscriber'";
$query = mysqli_query($connection, $select);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>RoyalUI Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
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
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List of Subscribers</h4>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            ID
                          </th>
                          <th>
                            Name
                          </th>
                          <th>
                            Home Address
                          </th>
                          <th>
                            Email
                          </th>
                          <th>
                            Contact Number
                          </th>
                          <th>
                            Subscription Status
                          </th>
                          <th>
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                            $num = mysqli_num_rows($query);
                            if ($num > 0) {
                                while ($row = mysqli_fetch_array($query)) {
                                  $sms = $row['sms'];
                                  if ($sms == "activated") {
                                      $action = "Deactivate";
                                  } else {
                                      $action = "Activate";
                                  }
                                echo "
                                <tr>
                                <td>". $row['id'] ."</td>
                                <td>". $row['name'] ."</td>
                                <td>". $row['address'] ."</td>
                                <td>" . $row['email'] . "</td>
                                <td>" . $row['contactNumber'] . "</td>
                                <td>" . $row['sms'] . "</td>
                                
                                <td>
                                    <a class='dropdown-item' href='users.php?id=".$row['id']."'><i class='dw dw-delete-3'></i><b>". $action ."</b></a>
                                    <br>
                                </td>
                            </tr>	
                                    ";
                                }
                            }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>

</html>
