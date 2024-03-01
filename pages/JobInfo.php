<?php
session_start();
include('NavBar.php'); 
include 'connection.php';
include 'functions.php';
$user_data = check_login($conn);
require_once('../assets/includes/classes/Database.php');
$database = new Database();
$jobID = isset($_GET['jobID']) ? $_GET['jobID'] : '';
$jobData = $database->getJobByID($jobID)->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Info</title>
</head>
<body>
<div class="container-fluid px-2 px-md-4">
      <div class="card card-body mx-3 mx-md-4 mt-n6">
        <div class="row gx-4 mb-2">
          <div class="col-auto">
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h4 class="mb-0"><?php echo $jobData['JobName']; ?></h4>
                <a href='editJob.php?jobID=<?php echo $jobID; ?>' class='btn btn-primary btn-sm'>Edit</a>
                <button class='btn btn-danger btn-sm' onclick='deleteJob(<?php echo $jobID; ?>)'>Delete</button>
                <a href='MakeInv.php?jobID=<?php echo $jobID; ?>' class='btn btn-primary btn-sm'>Forms</a>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <h6 class="mb-0">Job Details</h6>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label
                  ">Client Name</label>
                  <input type="text" class="form-control" value="<?php echo $jobData['FirstName'] . ' ' . $jobData['LastName']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Address</label>
                  <input type="text" class="form-control" value="<?php echo $jobData['Address']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Phone Number</label>
                  <input type="text" class="form-control" value="<?php echo $jobData['PhoneNumber']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Distance</label>
                  <input type="text" class="form-control" value="<?php echo $jobData['Distance']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">SQFT</label>
                  <input type="email" class="form-control" value="<?php echo $jobData['SQFT']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Revenue</label>
                  <input type="text" class="form-control" value="<?php echo $jobData['Revenue']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Labor Cost</label>
                  <input type="text" class="form-control" value="<?php echo $jobData['LaborCost']; ?>" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group
                ">
                  <label class="form-label
                  ">Material Cost</label>
                  <input type="text" class="form-control" value="<?php echo $jobData['MaterialCost']; ?>" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Profit</label>
                  <input type="text" class="form-control" value="<?php echo $jobData['Profit']; ?>" disabled>
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Days Worked</label>
                  <input type="text" class="form-control" value="<?php echo $jobData['DaysWorked']; ?>" disabled>
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Payment Method</label>
                  <input type="text" class="form-control" value="<?php echo $jobData['PaymentMethod']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Job Status</label>
                  <input type="text" class="form-control" value="<?php echo $jobData['Status']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Start Date</label>
                  <input type="text" class="form-control" value="<?php echo $jobData['startDate']; ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group
                ">
                  <label class="form-label
                  ">Complete Date</label>
                  <input type="text" class="form-control" value="<?php echo $jobData['completeDate']; ?>" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
  function deleteJob(jobID) {
    $.ajax({
        url: 'deleteJob.php',
        type: 'POST',
        data: { jobID: jobID },
      success: function (response) {
        window.location.href = 'myJobs.php';
      },
      error: function () {
        alert('Error occurred during the AJAX call.');
      }
    });
  }
</script>

</body>
</html>
