<?php
    require '../backend/db.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (isset($_POST['submit'])) {

        $contactNumber = $_POST['contactNumber'];

        $query = "DELETE * FROM `users` WHERE `contactNumber` = '$contactNumber'";
        if (mysqli_query($connection, $query)) {
            header("Location: ../index.php");
        }
    
    }
?>

<?php include "layouts/_header.php"; ?>
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg" style="background: #3486AE;">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="auth-form-transparent text-left p-3">
              <div class="brand-logo">
                <a href="#"><img src="images/city.png" alt="logo"></a>
                <a href="#"><img src="images/logo.png" alt="logo"></a>
                <a href="#"><img src="images/tayo.png" alt="logo"></a>
              </div>
              <h3 style="color: white;">Want To Cancel Subscription?</h3>
              <h6 class="font-weight-light" style="color: white;">Just Confirm Your Number to Unsubscribe</h6>
              <span style="font-size: 20px;">
							<?php if (!empty($errors)) { ?>
								<?php include "layouts/_error-messages.php" ?>
							<?php } ?>
						  </span>
              <form method="post" class="pt-3">
                <div class="form-group">
                  <label style="color: white;">Contact Number</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="ti-lock text-white"></i>
                      </span>
                    </div>
                    <input type="number" class="form-control form-control-lg border-left-0" id="contactNumber" name="contactNumber" value="<?= $_POST['contactNumber'] ?? ''?>" placeholder="Contact Number">                        
                  </div>
                </div>
                <div class="mb-4">
                  <!-- <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      I agree to all Terms & Conditions
                    </label>
                  </div> -->
                </div>
                <div class="mt-3">
                  <!-- <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="submit" value="SIGN UP" /> -->
                  <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="submit" value="Unsubscribe">
                </div>
                <div class="text-center mt-4 font-weight-light" style="color: white;">
                  Maintain Subscription? <a href="subscribe.php" class="text-primary"><span style="color: white; text-decoration: underline;">Go Back</span></a>
                </div>
              </form>
            </div>
          </div>
          <div class="col-lg-6 register-half-bg d-flex flex-row">
           
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <?php include "layouts/_footer.php"; ?>
