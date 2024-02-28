
<?php 
session_start();
include('NavBar.php');
include 'connection.php';
include 'functions.php';
$user_data = check_login($conn);
$user_name = $user_data['user_name'];
$img = $user_data['img'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
</head>
<body>
    <div class="container-fluid px-2 px-md-4">
      <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
        <span class="mask  bg-gradient-primary  opacity-6"></span>
      </div>
      <div class="card card-body mx-3 mx-md-4 mt-n6">
        <div class="row gx-4 mb-2">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="../assets/img/bruce-mars.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
              <h4 class="mb-0"><?php echo $user_name; ?></h4>
              </h5>
              <p class="mb-0 font-weight-normal text-sm">
                Contractor
              </p>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <h6 class="mb-0">Account Details</h6>
              <a href="edit-profile.php" class="text-secondary text-sm">Edit</a>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label
                  ">Full Name</label>
                  <input type="text" class="form-control" value="<?php echo $user_data['full_name']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Company</label>
                  <input type="text" class="form-control" value="<?php echo $user_data['comp_name']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Username</label>
                  <input type="text" class="form-control" value="<?php echo $user_data['user_name']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Password</label>
                  <input type="text" class="form-control" value="<?php echo $user_data['password']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Email</label>
                  <input type="email" class="form-control" value="<?php echo $user_data['email']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Phone</label>
                  <input type="text" class="form-control" value="<?php echo $user_data['phone_number']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Address</label>
                  <input type="text" class="form-control" value="<?php echo $user_data['address']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Image</label>
                  <img src="data:image/png;base64,<?php echo base64_encode($user_data['img']); ?>" alt="User Image">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.1.0"></script>
</body>

</html>