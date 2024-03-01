<?php
    session_start();
    include('NavBar.php');
    require_once('../assets/includes/classes/Database.php');
    $database = new Database();
    include 'connection.php';
    include 'functions.php';
    $user_data = check_login($conn);
    $user_id = $user_data['user_id'];
    echo "Welcome " . $user_data['full_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Open Jobs</p>
                <h4 class="mb-0"><?php $openJobs = $database->getNumberJobsOpen($user_id); echo $openJobs; ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than last month</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Jobs Completed</p>
                <h4 class="mb-0"><?php $jobsComp = $database->getNumberJobsCompleted($user_id); echo $jobsComp; ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span> than yesterday</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">weekend</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Average Job lifecycle</p>
                <h4 class="mb-0"><?php echo intval($database->getAvgDaysWorked($user_id)) . " days"; ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder">%3 </span>than last week</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">weekend</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Profit</p>
                <h4 class="mb-0">$<?php echo $database->getCash($user_id) + $database->getCheck($user_id); ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than last week</p>
            </div>
          </div>
        </div>

        
        <div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card my-4" style="max-width: 100%;">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-2 d-flex align-items-center">
                        <h6 class="text-white text-capitalize ps-3 me-2" style="font-size: 18px;">Open Jobs</h6>
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addJobModal" style="font-size: 14px;" onclick="redirectToMyJobs()">Add</button>
                    </div>
                    <table class="table">
                    <thead>
                            <tr>
                                <th scope="col" style="width: 10%;">Client</th>
                                <th scope="col" style="width: 15%;">Job Name</th>
                                <th scope="col" style="width: 15%;">Address</th>
                                <th scope="col" style="width: 15%;">Phone Number</th>
                                <th scope="col" style="width: 15%;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Use PHP to fetch and display job data from the database
                            $result = $database->getAllJobsOpenByID($user_id); // Replace with your actual method to fetch jobs
                            while ($row = $result->fetch_assoc()) {
                              $backgroundColor = '';
                                    switch ($row['Status']) {
                                        case 'Paid':
                                            $backgroundColor = 'lightblue';
                                            break;
                                        case 'Pending Payment':
                                            $backgroundColor = '#FFB600';
                                            break;
                                        case 'Active':
                                            $backgroundColor = 'lightgreen';
                                            break;
                                        default:
                                            $backgroundColor = ''; // Default color if none of the above
                                          }
                                          echo "<tr style='background-color: $backgroundColor; cursor: pointer;' class='job-row' data-job-id='" . $row['JobID'] . "'>";
                                          echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['ClientName']) ? $row['ClientName'] : 'N/A') . "</td>";
                                          echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['JobName']) ? $row['JobName'] : 'N/A') . "</td>";
                                          echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['Address']) ? $row['Address'] : 'N/A') . "</td>";
                                          echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['PhoneNumber']) ? $row['PhoneNumber'] : 'N/A') . "</td>";
                                          echo "<td style='font-size: 14px; background-color: $backgroundColor;'>" . (isset($row['Status']) ? $row['Status'] : 'N/A') . "</td>";
                                          $jobID = $row['JobID'];
                                        }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <canvas id="myStackedBarChart" width="400" height="500"></canvas>
            <style>
                #myStackedBarChart {
                    max-width: 100%; /* Adjust the maximum width for the chart */
                    margin: 0 auto; /* Center the chart horizontally */
                }
            </style>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sample data
        var data = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Revenue',
                backgroundColor: 'lightblue', 
                data: [<?php echo $database->getRevByMonth($user_id, '1'); ?>, <?php echo $database->getRevByMonth($user_id, '2'); ?>, <?php echo $database->getRevByMonth($user_id, '3'); ?>, <?php echo $database->getRevByMonth($user_id, '4'); ?>, <?php echo $database->getRevByMonth($user_id, '5'); ?>, <?php echo $database->getRevByMonth($user_id, '6'); ?>, <?php echo $database->getRevByMonth($user_id, '7'); ?>, <?php echo $database->getRevByMonth($user_id, '8'); ?>, <?php echo $database->getRevByMonth($user_id, '9'); ?>, <?php echo $database->getRevByMonth($user_id, '10'); ?>, <?php echo $database->getRevByMonth($user_id, '11'); ?>, <?php echo $database->getRevByMonth($user_id, '12'); ?>]
            }, {
                label: 'Expenses',
                backgroundColor: '#FFB600',
                data: [<?php echo $database->getExpByMonth($user_id, '1'); ?>, <?php echo $database->getExpByMonth($user_id, '2'); ?>, <?php echo $database->getExpByMonth($user_id, '3'); ?>, <?php echo $database->getExpByMonth($user_id, '4'); ?>, <?php echo $database->getExpByMonth($user_id, '5'); ?>, <?php echo $database->getExpByMonth($user_id, '6'); ?>, <?php echo $database->getExpByMonth($user_id, '7'); ?>, <?php echo $database->getExpByMonth($user_id, '8'); ?>, <?php echo $database->getExpByMonth($user_id, '9'); ?>, <?php echo $database->getExpByMonth($user_id, '10'); ?>, <?php echo $database->getExpByMonth($user_id, '11'); ?>, <?php echo $database->getExpByMonth($user_id, '12'); ?>]
            }, {
                label: 'Profit',
                backgroundColor: 'lightgreen',
                data: [<?php echo $database->getProfitByMonth($user_id, '1'); ?>, <?php echo $database->getProfitByMonth($user_id, '2'); ?>, <?php echo $database->getProfitByMonth($user_id, '3'); ?>, <?php echo $database->getProfitByMonth($user_id, '4'); ?>, <?php echo $database->getProfitByMonth($user_id, '5'); ?>, <?php echo $database->getProfitByMonth($user_id, '6'); ?>, <?php echo $database->getProfitByMonth($user_id, '7'); ?>, <?php echo $database->getProfitByMonth($user_id, '8'); ?>, <?php echo $database->getProfitByMonth($user_id, '9'); ?>, <?php echo $database->getProfitByMonth($user_id, '10'); ?>, <?php echo $database->getProfitByMonth($user_id, '11'); ?>, <?php echo $database->getProfitByMonth($user_id, '12'); ?>]
            }]
        };

        // Chart configuration
        var options = {
            responsive: true,
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    stacked: true
                }
            }
        };

        // Get the canvas element
        var ctx = document.getElementById('myStackedBarChart').getContext('2d');

        // Create the stacked bar chart
        var myStackedBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
    });
</script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    function redirectToMyJobs() {
    window.location.href = "../pages/myjobs_add.php";
  }
  document.addEventListener('DOMContentLoaded', function () {
        const jobRows = document.querySelectorAll('.job-row');

        jobRows.forEach(row => {
            row.addEventListener('click', function () {
                const jobId = this.getAttribute('data-job-id');
                window.location.href = `JobInfo.php?jobID=${jobId}`;
            });
        });
    });
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.1.0"></script>
</body>

</html>